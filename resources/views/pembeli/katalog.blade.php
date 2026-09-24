<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buah - FreshFruit</title>
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
            <div class="flex items-center gap-5">
                <a href="{{ route('dashboard.pembeli') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                    Dashboard
                </a>
                <a href="{{ route('pembeli.cart') }}" class="relative text-sm font-medium text-gray-700 hover:text-green-600 transition">
                    🛒 Keranjang
                    @if (session('cart') && count(session('cart')) > 0)
                        <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Katalog Buah Segar 🍇</h1>
            <p class="text-gray-500 text-sm mt-1">Pilih buah favoritmu dan tambahkan ke keranjang.</p>
        </div>

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

        @if ($products->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
                <p class="text-5xl mb-3">🍊</p>
                <p class="text-gray-500">Belum ada produk tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">

                        <div class="h-40 bg-lime-50 flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl">🍎</span>
                            @endif
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $product->title }}</h3>
                            <p class="text-gray-400 text-xs mt-1 line-clamp-2 flex-1">{{ $product->description ?? '-' }}</p>

                            <div class="flex items-center justify-between mt-3">
                                <span class="font-bold text-green-600">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="text-xs text-gray-400">Stok: {{ $product->stock }}</span>
                            </div>

                            <form action="{{ route('pembeli.cart.add', $product) }}" method="POST" class="mt-4 flex items-center gap-2">
                                @csrf
                                <input
                                    type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock }}"
                                    class="w-16 px-2 py-1.5 rounded-lg border border-gray-200 text-sm text-center focus:border-green-500 focus:ring-1 focus:ring-green-200 outline-none"
                                >
                                <button
                                    type="submit"
                                    class="flex-1 bg-gradient-to-r from-green-500 to-lime-500 text-white text-sm font-semibold py-1.5 rounded-lg hover:shadow-md transition"
                                >
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>

</body>

</html>