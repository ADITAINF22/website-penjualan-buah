<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Transaksi - FreshFruit</title>
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
                <span class="ml-2 text-xs font-semibold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">
                    Admin
                </span>
            </div>
            <a href="{{ route('dashboard.admin') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                ← Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Semua Transaksi 💳</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau seluruh transaksi online dan kasir.</p>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-3xl">
                    🛒
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Penjualan Online</p>
                    <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($totalOnline, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center text-3xl">
                    🧾
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Penjualan Kasir</p>
                    <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($totalKasir, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('admin.transactions.index') }}"
                class="text-sm font-medium px-4 py-2 rounded-xl transition {{ !request('type') || request('type') === 'semua' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                Semua
            </a>
            <a href="{{ route('admin.transactions.index', ['type' => 'online']) }}"
                class="text-sm font-medium px-4 py-2 rounded-xl transition {{ request('type') === 'online' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                Online (Pembeli)
            </a>
            <a href="{{ route('admin.transactions.index', ['type' => 'kasir']) }}"
                class="text-sm font-medium px-4 py-2 rounded-xl transition {{ request('type') === 'kasir' ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                Kasir
            </a>
        </div>

        {{-- Daftar transaksi --}}
        @if ($orders->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
                <p class="text-5xl mb-3">📭</p>
                <p class="text-gray-500">Belum ada transaksi.</p>
            </div>
        @else
            <div class="space-y-5">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    Transaksi #{{ $order->id }}
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full ml-2 {{ $order->type === 'online' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $order->type === 'online' ? 'Online' : 'Kasir' }}
                                    </span>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                    —
                                    @if ($order->type === 'online')
                                        Pembeli: {{ $order->user->name ?? '-' }}
                                    @else
                                        Kasir: {{ $order->user->name ?? '-' }} | Pelanggan: {{ $order->customer_name ?? '-' }}
                                    @endif
                                </p>
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