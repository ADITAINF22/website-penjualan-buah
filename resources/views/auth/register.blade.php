<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - FreshFruit</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-lime-50 to-orange-50 px-4 py-10">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        {{-- Sisi kiri: ilustrasi / branding --}}
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-orange-400 to-lime-500 p-10 flex-col justify-between text-white relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <span class="text-3xl">🍎</span>
                    <span class="text-2xl font-bold">FreshFruit</span>
                </div>

                <h2 class="text-3xl font-bold leading-snug mb-3">
                    Gabung Bersama<br>Kami Sekarang
                </h2>
                <p class="text-white/90 text-sm leading-relaxed">
                    Daftar dan nikmati kemudahan belanja buah segar pilihan setiap hari.
                </p>
            </div>

            <div class="relative z-10 flex gap-3 text-4xl">
                <span>🍊</span>
                <span>🍇</span>
                <span>🍓</span>
                <span>🥝</span>
            </div>
        </div>

        {{-- Sisi kanan: form register --}}
        <div class="w-full md:w-1/2 p-8 sm:p-12">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Buat Akun Baru 🌱</h1>
                <p class="text-gray-500 text-sm mt-1">Lengkapi data di bawah untuk mendaftar</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Nama lengkap"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Daftar sebagai</label>
                    <select
                        name="role"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition bg-white"
                    >
                        <option value="">-- Pilih Role --</option>
                        <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>
                            Pembeli
                        </option>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>
                            Kasir
                        </option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-orange-400 to-lime-500 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg hover:from-orange-500 hover:to-lime-600 transition mt-2"
                >
                    Register
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">
                    Login di sini
                </a>
            </p>

        </div>

    </div>

</body>

</html>