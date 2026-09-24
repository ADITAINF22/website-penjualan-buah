<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Produk - FreshFruit</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

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

                <span class="text-2xl">
                    🍎
                </span>

                <span class="text-xl font-bold text-gray-800">
                    FreshFruit
                </span>

                <span class="ml-2 text-xs font-semibold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">
                    Admin
                </span>

            </div>


            <a
                href="{{ route('dashboard.admin') }}"
                class="text-sm font-medium text-gray-500 hover:text-gray-800 transition"
            >
                ← Kembali ke Dashboard
            </a>

        </div>

    </nav>


    {{-- Konten --}}
    <main class="max-w-6xl mx-auto px-6 py-10">


        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    Kelola Produk 🍇
                </h1>

                <p class="text-gray-500 text-sm mt-1">
                    Daftar seluruh buah yang dijual di FreshFruit.
                </p>

            </div>


            {{-- Tombol Tambah Produk --}}
            <a
                href="{{ route('products.create') }}"
                class="bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:from-green-600 hover:to-lime-600 transition flex items-center gap-2"
            >

                <span>
                    +
                </span>

                <span>
                    Tambah Produk
                </span>

            </a>

        </div>


        {{-- Pesan sukses --}}
        @if (session('success'))

            <div class="mb-6 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">

                <span>
                    ✅
                </span>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- Tabel Produk --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">


            @if ($products->isEmpty())


                {{-- Jika belum ada produk --}}
                <div class="text-center py-16">

                    <p class="text-5xl mb-3">
                        🍊
                    </p>

                    <p class="text-gray-500">
                        Belum ada produk. Yuk tambahkan yang pertama!
                    </p>

                </div>


            @else


                {{-- Tabel --}}
                <table class="w-full text-sm">


                    {{-- Header --}}
                    <thead>

                        <tr class="bg-gray-50 text-left text-gray-500">

                            <th class="px-6 py-4 font-medium">
                                Gambar
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Nama
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Harga
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Stok
                            </th>

                            <th class="px-6 py-4 font-medium text-right">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    {{-- Isi --}}
                    <tbody class="divide-y divide-gray-100">


                        @foreach ($products as $product)


                            <tr class="hover:bg-gray-50 transition">


                                {{-- Gambar --}}
                                <td class="px-6 py-4">

                                    @if ($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->title }}"
                                            class="w-12 h-12 rounded-xl object-cover"
                                        >

                                    @else

                                        <div class="w-12 h-12 rounded-xl bg-lime-100 flex items-center justify-center text-xl">

                                            🍎

                                        </div>

                                    @endif

                                </td>


                                {{-- Nama --}}
                                <td class="px-6 py-4 font-semibold text-gray-800">

                                    {{ $product->title }}

                                </td>


                                {{-- Harga --}}
                                <td class="px-6 py-4 text-gray-600">

                                    Rp{{ number_format($product->price, 0, ',', '.') }}

                                </td>


                                {{-- Stok --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="text-xs font-semibold px-2.5 py-1 rounded-full
                                        {{ $product->stock > 0
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700'
                                        }}"
                                    >

                                        {{ $product->stock }} pcs

                                    </span>

                                </td>


                                {{-- Aksi --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-3">


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            class="text-sm font-medium text-blue-600 hover:underline"
                                        >

                                            Edit

                                        </a>


                                        {{-- Hapus --}}
                                        <form
                                            action="{{ route('products.destroy', $product) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-sm font-medium text-red-600 hover:underline"
                                            >

                                                Hapus

                                            </button>

                                        </form>


                                    </div>

                                </td>


                            </tr>


                        @endforeach


                    </tbody>

                </table>


            @endif


        </div>


        {{-- Pagination --}}
        <div class="mt-6">

            {{ $products->links() }}

        </div>


    </main>


</body>

</html>
