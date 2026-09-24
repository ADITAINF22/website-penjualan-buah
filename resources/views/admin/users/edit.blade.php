<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - FreshFruit</title>
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
            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                ← Kembali ke Pengguna
            </a>
        </div>
    </nav>

    <main class="max-w-xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Edit Pengguna ✏️</h1>
            <p class="text-gray-500 text-sm mt-1">Perbarui data dan role pengguna.</p>
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

        <div class="bg-white rounded-2xl shadow-sm p-8">

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">

                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Role</label>
                    <select
                        name="role"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition bg-white"
                    >
                        <option value="pembeli" {{ old('role', $user->role) == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:from-green-600 hover:to-lime-600 transition"
                    >
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </main>

</body>

</html>