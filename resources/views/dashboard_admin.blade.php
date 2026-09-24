<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - FreshFruit</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-green-50 via-lime-50 to-orange-50">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🍎</span>
                <span class="text-xl font-bold text-gray-800">FreshFruit</span>
                <span class="ml-2 text-xs font-semibold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">
                    Admin
                </span>
                @if ($lowStockProducts->isNotEmpty())
                    <span class="ml-2 flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-100 px-2.5 py-1 rounded-full">
                        🔔 {{ $lowStockProducts->count() }} stok menipis
                    </span>
                @endif
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="text-sm font-medium text-gray-500 hover:text-red-600 transition flex items-center gap-1.5"
                >
                    <span>Logout</span>
                    <span>🚪</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Halo, {{ Auth::user()->name }} 👑
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Kelola seluruh sistem FreshFruit dari sini.
            </p>
        </div>

        {{-- Kartu info akun --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                    👤
                </div>
                <div>
                    <p class="text-xs text-gray-400">Nama</p>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-lime-100 flex items-center justify-center text-2xl">
                    ✉️
                </div>
                <div>
                    <p class="text-xs text-gray-400">Email</p>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">
                    🏷️
                </div>
                <div>
                    <p class="text-xs text-gray-400">Role</p>
                    <p class="font-semibold text-gray-800 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>

        </div>

        {{-- Statistik produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-lime-100 flex items-center justify-center text-3xl">
                    🍇
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-orange-100 flex items-center justify-center text-3xl">
                    📦
                </div>
                <div>
                    <p class="text-xs text-gray-400">Total Stok</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalStock }}</p>
                </div>
            </div>

        </div>

        {{-- Peringatan stok menipis --}}
        @if ($lowStockProducts->isNotEmpty())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-2xl">⚠️</span>
                    <h2 class="text-lg font-bold text-red-700">Stok Menipis</h2>
                </div>

                <div class="space-y-2">
                    @foreach ($lowStockProducts as $product)
                        <div class="flex items-center justify-between bg-white rounded-xl px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-8 h-8 rounded-lg object-cover">
                                @else
                                    <span class="text-lg">🍎</span>
                                @endif
                                <span class="text-sm font-medium text-gray-700">{{ $product->title }}</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $product->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $product->stock == 0 ? 'Habis' : $product->stock . ' pcs tersisa' }}
                                </span>
                                <a href="{{ route('products.edit', $product) }}" class="text-xs font-medium text-blue-600 hover:underline">
                                    Update Stok
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Menu kelola --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

            <a href="{{ route('products.index') }}" class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-md transition block">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">🍇</span>
                    <h2 class="text-lg font-bold text-gray-800">Kelola Produk</h2>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Tambah, edit, dan hapus data buah — termasuk harga dan stok.
                </p>
            </a>

            <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-md transition block">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">👥</span>
                    <h2 class="text-lg font-bold text-gray-800">Kelola Pengguna</h2>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Lihat dan kelola akun pembeli serta kasir yang terdaftar.
                </p>
            </a>

            <a href="{{ route('admin.transactions.index') }}" class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-md transition block">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">💳</span>
                    <h2 class="text-lg font-bold text-gray-800">Semua Transaksi</h2>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Pantau transaksi online dari pembeli dan transaksi kasir.
                </p>
            </a>

        </div>

    </main>

</body>

</html>