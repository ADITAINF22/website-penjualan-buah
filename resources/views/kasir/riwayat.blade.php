<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - FreshFruit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-green-50 via-lime-50 to-orange-50">

    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🍎</span>
                <span class="text-xl font-bold text-gray-800">FreshFruit</span>
            </div>
            <a href="{{ route('kasir.pos') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                ← Transaksi Baru
            </a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold text-gray-800 mb-8">Riwayat Transaksi 🧾</h1>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
                <p class="text-5xl mb-3">🧾</p>
                <p class="text-gray-500">Belum ada transaksi.</p>
            </div>
        @else
            <div class="space-y-5">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    Transaksi #{{ $order->id }} — {{ $order->customer_name }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700 capitalize">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="divide-y divide-gray-100 border-t border-gray-100">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between py-2 text-sm">
                                    <span class="text-gray-600">{{ $item->title }} x{{ $item->quantity }}</span>
                                    <span class="text-gray-800">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                            <span class="text-gray-500 text-sm">Total</span>
                            <span class="font-bold text-gray-800">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif

    </main>

</body>

</html>