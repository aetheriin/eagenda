<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen bg-white">
        @include('layouts.navigation')

        <!-- ✅ Flash Message Success -->
        @if(session('success'))
            <div id="flash-success" class="fixed top-4 right-4 bg-gray-800 text-white px-4 py-2 rounded shadow-lg z-50">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const flash = document.getElementById('flash-success');
                    if(flash) flash.style.display = 'none';
                }, 3000);
            </script>
        @endif

        <!-- ✅ Flash Message Error -->
        @if($errors->any())
            <div id="flash-error" class="fixed top-4 right-4 bg-red-600 text-white px-4 py-2 rounded shadow-lg z-50">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <script>
                setTimeout(() => {
                    const flash = document.getElementById('flash-error');
                    if(flash) flash.style.display = 'none';
                }, 5000);
            </script>
        @endif

        <!-- ✅ End Flash Messages -->

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-6 sm:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-6 py-6">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <!-- <footer class="text-center text-gray-500 text-sm py-6 border-t mt-10">
            <div class="flex justify-center items-center space-x-2">
                <span>© BPS Kota Dumai</span>
            </div>
        </footer> -->
    </div>
</body>
</html>
