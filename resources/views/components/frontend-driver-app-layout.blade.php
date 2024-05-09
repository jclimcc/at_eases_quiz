<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class='dark'>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="flex flex-col h-screen">
        <!-- Content Area (80%) -->

        <div class="flex flex-col justify-between h-full px-8">
            @if (isset($header))
                <header class="flex items-center justify-center h-1/5 ">

                    {{ $header }}

                </header>
            @endif

            <main class="overflow-auto h-4/5">
                {{ $slot }}
            </main>
        </div>

        <!-- Menu Area (20%) -->
        <div class="flex items-center justify-between bg-gray-200 h-1/5">
            <!-- Menu Items -->
            <a href="{{ route('front.driver.dashboard') }}"
                class="flex items-center justify-center flex-1 h-full px-4 text-bluec">
                <i class="mr-2 fas fa-home fa-2x"></i></a>
            <a href="{{ route('front.driver.customerList') }}"
                class="flex items-center justify-center flex-1 h-full px-4 text-bluec">
                <i class="mr-2 fas fa-truck fa-2x"></i></a>
            <a href="{{ route('front.driver.dashboard') }}"
                class="flex items-center justify-center flex-1 h-full px-4 text-bluec"><i
                    class="mr-2 fas fa-box fa-2x"></i></a>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
