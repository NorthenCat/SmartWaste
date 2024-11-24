<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="SmartWaste - Solusi untuk melindungi lingkungan dengan mendaur ulang sampah">
    <meta name="author" content="SmartWaste">
    <meta name="keywords" content="smartwaste, recycle, telkom, telkom university">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="SmartWaste">
    <meta property="og:description"
        content="SmartWaste - Solusi untuk melindungi lingkungan dengan mendaur ulang sampah">
    <meta property="og:image" content="your-og-image-url.jpg">
    <meta property="og:url" content="https://yourwebsite.com/dashboard">


    {{-- Icon --}}
    <link rel="icon" href="path/to/your/favicon.ico" type="image/x-icon">
    <link rel="icon" href="path/to/your/favicon.png" type="image/png">

    <!-- Google Fonts (optional if you need custom fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- AlpineJs --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>SmartWaste</title>

    {{-- Development --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body
    class="bg-gray-300 flex items-center rounded-lg w-full h-full mx-auto my-auto overflow-x-hidden m-0 max-w-[430px]">

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="fixed inset-0 z-50 flex items-center justify-center bg-white bg-opacity-75">
        <div class="flex flex-col items-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-[#496948]"></div>
            <p class="mt-4 text-[#496948] font-semibold">Loading...</p>
        </div>
    </div>

    @stack('first-script')
    @yield('content')
    @stack('end-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spinner = document.getElementById('loadingSpinner');
            window.addEventListener('load', function() {
                spinner.style.display = 'none';
            });
        });
    </script>
</body>

</html>