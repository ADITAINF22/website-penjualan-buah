<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - FreshFruit</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-lime-50 to-orange-50 px-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        {{-- Sisi kiri: ilustrasi / branding --}}
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-green-500 to-lime-400 p-10 flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <span class="text-3xl">🍎</span>
                    <span class="text-2xl font-bold">FreshFruit</span>
                </div>

                <h2 class="text-3xl font-bold leading-snug mb-3">
                    Buah Segar,<br>Langsung dari Kebun
                </h2>
                <p class="text-white/90 text-sm leading-relaxed">
                    Pesan buah pilihan berkualitas terbaik dan nikmati kesegarannya sampai ke tangan Anda.
                </p>
            </div>

            <div class="relative z-10 flex gap-3 text-4xl">
                <span>🍊</span>
                <span>🍇</span>
                <span>🍓</span>
                <span>🥝</span>
            </div>
        </div>

        {{-- Sisi kanan: form login --}}
        <div class="w-full md:w-1/2 p-8 sm:p-12">

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Selamat Datang 👋</h1>
                <p class="text-gray-500 text-sm mt-1">Silakan login untuk melanjutkan belanja</p>
            </div>

            @if (session('success'))
                <div class="mb-6 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg hover:from-green-600 hover:to-lime-600 transition"
                >
                    Login
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>

    </div>

</body>

</html>