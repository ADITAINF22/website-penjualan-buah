<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function catalog()
    {
        $products = Product::where('stock', '>', 0)->latest()->get();

        return view('pembeli.katalog', compact('products'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
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

        session()->put('cart', $cart);

        return back()->with('success', $product->title . ' ditambahkan ke keranjang.');
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('pembeli.keranjang', compact('cart', 'total'));
    }

    public function updateCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $product = Product::find($productId);

            if ($product && $request->quantity > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }

            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        DB::beginTransaction();

        try {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'selesai',
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
            session()->forget('cart');

            return redirect()->route('pembeli.riwayat')->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('pembeli.riwayat', compact('orders'));
    }
}
