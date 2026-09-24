<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function pos()
    {
        $products = Product::where('stock', '>', 0)->latest()->get();
        $cart = session()->get('kasir_cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('kasir.pos', compact('products', 'cart', 'total'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('kasir_cart', []);
        $qty = $request->quantity;

        if (isset($cart[$product->id])) {
            $qty += $cart[$product->id]['quantity'];
        }

        if ($qty > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi untuk ' . $product->title . '.');
        }

        $cart[$product->id] = [
            'title' => $product->title,
            'price' => $product->price,
            'quantity' => $qty,
        ];

        session()->put('kasir_cart', $cart);

        return back()->with('success', $product->title . ' ditambahkan.');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('kasir_cart', []);
        unset($cart[$productId]);
        session()->put('kasir_cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clearCart()
    {
        session()->forget('kasir_cart');

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
        ]);

        $cart = session()->get('kasir_cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        DB::beginTransaction();

        try {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id'       => Auth::id(),
                'type'          => 'kasir',
                'customer_name' => $request->customer_name ?: 'Pelanggan Umum',
                'total'         => $total,
                'status'        => 'selesai',
            ]);

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception('Stok produk ' . $item['title'] . ' tidak mencukupi.');
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'title'      => $item['title'],
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('kasir_cart');

            return redirect()->route('kasir.riwayat')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('type', 'kasir')
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('kasir.riwayat', compact('orders'));
    }
}
