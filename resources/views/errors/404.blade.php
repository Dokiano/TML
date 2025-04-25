<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - DCMS</title>
    <link href="{{ asset('admin/img/TML Logo.jpg') }}" rel="icon">
    <link href="{{ asset('admin/img/TML Logo.jpg') }}" rel="apple-touch-icon">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center min-h-screen">
    <style>
        .gradient-border {
            border: 2px solid transparent;
            border-image: linear-gradient(to bottom right, #6ABF69, #6A9DF0);
            border-image-slice: 1;
        }
    </style>
    <div class="text-center bg-white rounded-xl shadow-2xl max-w-md mx-auto">
        <div
            class="flex justify-between w-full items-center mb-4 rounded-t-xl bg-gradient-to-br from-[#6ABF69] to-[#6A9DF0] px-4 py-2">
            <div class="p-3 bg-white rounded-full h-[70px] w-[70px]">
                <img src="{{ asset('admin/img/logobg-ic.png') }}" class="" alt="">
            </div>
            <p class="font-bold text-white text-lg text-shadow-lg" style="line-height: 1.3;">
                DOCUMENT CONTROL
                <br>MANAGEMENT SYSTEM
            </p>
            <div class="h-[70px] w-[70px]"></div>
        </div>
        <div class="mb-6">
            <!-- Embed the SVG here, either as an <img> or inline SVG -->
            <img src="{{ asset('404v2.svg') }}" alt="404 Image" class="mx-auto mb-6 h-40">
        </div>
        <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Oops!</h1>
        <p class="text-gray-600 text-lg mb-5 px-4">Sepertinya halaman yang Anda cari tidak ditemukan. Jangan khawatir,
            ayo
            kembali ke halaman utama!</p>

        <!-- Hover Button -->
        <a href="{{ url('/') }}"
            class="mb-6 relative inline-block px-8 py-3  text-gray-800 hover:text-white font-semibold uppercase tracking-wide overflow-hidden group hover:bg-gradient-to-br from-[#6ABF69] to-[#6A9DF0] gradient-border ">
            <span class="relative z-10">Dashboard</span>
        </a>
    </div>
</body>

</html>
