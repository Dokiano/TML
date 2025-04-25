<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white rounded-xl shadow-2xl max-w-md mx-auto">
        <div class="mb-6">
            <!-- Embed the SVG here, either as an <img> or inline SVG -->
            <img src="{{ asset('404.svg') }}" alt="404 Image" class="mx-auto mb-6 h-40">
        </div>
        <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Oops!</h1>
        <p class="text-gray-600 text-lg mb-6">Sepertinya halaman yang Anda cari tidak ditemukan. Jangan khawatir, ayo
            kembali ke halaman utama!</p>

        <!-- Hover Button -->
        <a href="{{ url('/') }}"
            class="relative inline-block px-8 py-3 border border-yellow-400 text-gray-800 hover:text-white font-semibold uppercase tracking-wide rounded-lg overflow-hidden group hover:bg-yellow-500 transition-all duration-300">
            <span class="relative z-10">Dashboard</span>
            <!-- Efek background saat hover -->
            <div
                class="absolute inset-0 bg-yellow-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left h-full w-full -z-10">
            </div>
        </a>
    </div>
</body>

</html>
