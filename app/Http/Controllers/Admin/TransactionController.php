<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'user'])->latest();

        if ($request->filled('type') && $request->type !== 'semua') {
            $query->where('type', $request->type);
        }

        $orders = $query->paginate(10)->withQueryString();

        $totalOnline = Order::where('type', 'online')->sum('total');
        $totalKasir = Order::where('type', 'kasir')->sum('total');

        return view('admin.transactions.index', compact('orders', 'totalOnline', 'totalKasir'));
    }
}
