<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS - FreshFruit</title>
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
                <span class="ml-2 text-xs font-semibold text-orange-600 bg-orange-100 px-2.5 py-1 rounded-full">
                    Kasir
                </span>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ route('dashboard.kasir') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                    Dashboard
                </a>
                <a href="{{ route('kasir.riwayat') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                    Riwayat
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold text-gray-800 mb-8">Kasir - Transaksi Baru 🧾</h1>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Daftar produk --}}
            <div class="lg:col-span-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @forelse ($products as $product)
                        <div class="bg-white rounded-2xl shadow-sm p-4 flex flex-col">
                            <div class="h-20 bg-lime-50 rounded-xl flex items-center justify-center mb-3">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    <span class="text-3xl">🍎</span>
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-800">{{ $product->title }}</p>
                            <p class="text-xs text-gray-400 mb-1">Stok: {{ $product->stock }}</p>
                            <p class="text-sm font-bold text-green-600 mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

                            <form action="{{ route('kasir.cart.add', $product) }}" method="POST" class="mt-auto flex items-center gap-1.5">
                                @csrf
                                <input
                                    type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="w-12 px-1.5 py-1 rounded-lg border border-gray-200 text-xs text-center focus:border-green-500 outline-none"
                                >
                                <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-lime-500 text-white text-xs font-semibold py-1.5 rounded-lg hover:shadow-md transition">
                                    + Tambah
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-full text-center py-10">Belum ada produk tersedia.</p>
                    @endforelse
                </div>
            </div>

            {{-- Keranjang transaksi --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
                <h2 class="font-bold text-gray-800 mb-4">Keranjang Transaksi</h2>

                @if (empty($cart))
                    <p class="text-sm text-gray-400 text-center py-8">Belum ada produk dipilih.</p>
                @else
                    <div class="space-y-3 mb-4">
                        @foreach ($cart as $productId => $item)
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="font-medium text-gray-700">{{ $item['title'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $item['quantity'] }} x Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                    <form action="{{ route('kasir.cart.remove', $productId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs">✕</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-100 pt-4 mb-4">
                        <span class="text-gray-500 text-sm">Total</span>
                        <span class="text-lg font-bold text-gray-800">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('kasir.checkout') }}" method="POST" class="space-y-3">
                        @csrf
                        <input
                            type="text"
                            name="customer_name"
                            placeholder="Nama pelanggan (opsional)"
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-200 outline-none"
                        >
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg transition"
                        >
                            Selesaikan Transaksi
                        </button>
                    </form>

                    <form action="{{ route('kasir.cart.clear') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-xs text-gray-400 hover:text-red-500 transition">
                            Kosongkan Keranjang
                        </button>
                    </form>
                @endif
            </div>

        </div>

    </main>

</body>

</html>