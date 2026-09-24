<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - FreshFruit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-lime-50 to-orange-50 px-4">
    <div class="text-center">
        <p class="text-6xl mb-4">🚫</p>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/dashboard') }}" class="inline-block bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
            Kembali ke Dashboard
        </a>
    </div>
</body>

</html>