<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Kasir - FreshFruit</title>

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
                <span class="ml-2 text-xs font-semibold text-orange-600 bg-orange-100 px-2.5 py-1 rounded-full">
                    Kasir
                </span>
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
                Selamat datang, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Berikut ringkasan akun dan aktivitas kasir Anda.
            </p>
        </div>

        {{-- Kartu info akun --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">

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
                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-2xl">
                    🏷️
                </div>
                <div>
                    <p class="text-xs text-gray-400">Role</p>
                    <p class="font-semibold text-gray-800 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>

        </div>

        {{-- Menu kasir --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <a href="{{ route('kasir.pos') }}" class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-md transition block">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">🧾</span>
                    <h2 class="text-lg font-bold text-gray-800">Transaksi Baru</h2>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Input transaksi penjualan untuk pelanggan yang datang langsung.
                </p>
            </a>

            <a href="{{ route('kasir.riwayat') }}" class="bg-white rounded-2xl shadow-sm p-8 hover:shadow-md transition block">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">📋</span>
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Transaksi</h2>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Lihat semua transaksi yang pernah kamu input.
                </p>
            </a>

        </div>

    </main>

</body>

</html>