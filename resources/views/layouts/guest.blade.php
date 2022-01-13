<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000000"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="text-blueGray-700 antialiased">
<div class="font-sans text-gray-900 antialiased">
    <main>
        <section class="relative w-full h-full py-10 min-h-screen">
            <div class="absolute top-0 w-full h-full bg-blueGray-800 bg-full bg-no-repeat" style="background-image: url({{ asset('images/register_bg_2.png') }})"></div>

            <div class="container mx-auto px-4 h-full">
                <div class="flex content-center items-center justify-center h-full">
                    {{ $slot }}
                </div>
            </div>

            <footer class="absolute w-full bottom-0 bg-blueGray-800 pb-6">
                <div class="container mx-auto px-4">
                    <hr class="mb-6 border-b-1 border-blueGray-600"/>
                </div>
            </footer>
        </section>
    </main>
</div>
</body>
</html>
