<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Produk - FreshFruit</title>

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
            </div>

            <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                ← Kembali ke Produk
            </a>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="max-w-2xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Produk Baru 🍓</h1>
            <p class="text-gray-500 text-sm mt-1">Isi detail buah yang ingin ditambahkan.</p>
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

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">

                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        placeholder="Contoh: Apel Fuji"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="3"
                        placeholder="Deskripsi singkat produk (opsional)"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga (Rp)</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            required
                            min="0"
                            step="0.01"
                            placeholder="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok</label>
                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock') }}"
                            required
                            min="0"
                            placeholder="0"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-100 outline-none transition"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Produk</label>
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-green-100 file:text-green-700 file:font-medium hover:file:bg-green-200 transition"
                    >
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:from-green-600 hover:to-lime-600 transition"
                    >
                        Simpan Produk
                    </button>

                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800 transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </main>

</body>

</html>