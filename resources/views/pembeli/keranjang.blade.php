<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - FreshFruit</title>
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
            <a href="{{ route('pembeli.katalog') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                ← Kembali Belanja
            </a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-10">

        <h1 class="text-2xl font-bold text-gray-800 mb-8">Keranjang Belanja 🛒</h1>

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

        @if (empty($cart))
            <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
                <p class="text-5xl mb-3">🛒</p>
                <p class="text-gray-500 mb-4">Keranjang kamu masih kosong.</p>
                <a href="{{ route('pembeli.katalog') }}" class="text-green-600 font-semibold hover:underline">
                    Mulai belanja
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm divide-y divide-gray-100 overflow-hidden">
                @foreach ($cart as $productId => $item)
                    <div class="flex items-center justify-between p-5">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item['title'] }}</p>
                            <p class="text-sm text-gray-500">Rp{{ number_format($item['price'], 0, ',', '.') }} / pcs</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <form action="{{ route('pembeli.cart.update', $productId) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item['quantity'] }}"
                                    min="1"
                                    class="w-16 px-2 py-1.5 rounded-lg border border-gray-200 text-sm text-center focus:border-green-500 focus:ring-1 focus:ring-green-200 outline-none"
                                >
                                <button type="submit" class="text-xs font-medium text-blue-600 hover:underline">
                                    Update
                                </button>
                            </form>

                            <form action="{{ route('pembeli.cart.remove', $productId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 mt-6 flex items-center justify-between">
                <span class="text-gray-500">Total Belanja</span>
                <span class="text-xl font-bold text-gray-800">Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('pembeli.checkout') }}" method="POST" class="mt-6">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition"
                >
                    Checkout Sekarang
                </button>
            </form>
        @endif

    </main>

</body>

</html>