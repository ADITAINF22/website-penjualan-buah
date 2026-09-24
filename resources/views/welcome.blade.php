<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshFruit - Buah Segar Setiap Hari</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-white">

    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-sm sticky top-0 z-10 border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🍎</span>
                <span class="text-xl font-bold text-gray-800">FreshFruit</span>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-green-600 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-lime-500 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
                    Daftar
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-green-50 via-lime-50 to-orange-50 px-6 py-20">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

            <div>
                <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                    🍓 Segar Langsung dari Kebun
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 leading-tight mb-5">
                    Buah Segar,<br>Kapan Saja <span class="text-green-600">Kamu Mau</span>
                </h1>
                <p class="text-gray-500 leading-relaxed mb-8">
                    Pesan buah pilihan berkualitas terbaik dari FreshFruit — dipilih langsung dari kebun terbaik, sampai ke tanganmu dengan tetap segar.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold px-6 py-3 rounded-xl shadow-md hover:shadow-lg transition">
                        Mulai Belanja
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:text-green-600 transition">
                        Sudah punya akun?
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 text-7xl">
                <span class="animate-bounce" style="animation-delay: 0s">🍎</span>
                <span class="animate-bounce" style="animation-delay: 0.2s">🍊</span>
                <span class="animate-bounce" style="animation-delay: 0.4s">🍇</span>
                <span class="animate-bounce" style="animation-delay: 0.6s">🍓</span>
            </div>

        </div>
    </section>

    {{-- Katalog preview --}}
    <section class="max-w-6xl mx-auto px-6 py-16">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Buah Pilihan Hari Ini 🍇</h2>
                <p class="text-gray-500 text-sm mt-1">Beberapa buah segar yang tersedia sekarang.</p>
            </div>
            <a href="{{ route('register') }}" class="text-sm font-semibold text-green-600 hover:underline">
                Lihat Semua →
            </a>
        </div>

        @if ($products->isEmpty())
            <div class="text-center py-16 bg-gray-50 rounded-2xl">
                <p class="text-5xl mb-3">🍊</p>
                <p class="text-gray-500">Belum ada produk tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-5">
                @foreach ($products as $product)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                        <div class="h-28 bg-lime-50 flex items-center justify-center">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl">🍎</span>
                            @endif
                        </div>
                        <div class="p-3">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->title }}</p>
                            <p class="text-xs font-bold text-green-600 mt-1">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-br from-green-500 to-lime-500 px-6 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Siap Menikmati Buah Segar Setiap Hari?
            </h2>
            <p class="text-white/90 mb-8">
                Daftar sekarang dan mulai pesan buah favoritmu hanya dalam beberapa klik.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-green-600 font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg transition">
                Daftar Gratis
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-50 px-6 py-8 text-center">
        <p class="text-sm text-gray-400">
            © {{ date('Y') }} FreshFruit. Buah segar, langsung dari kebun.
        </p>
    </footer>

</body>

</html>