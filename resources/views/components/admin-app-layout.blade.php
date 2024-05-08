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


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('admin.layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <div class="flex flex-col min-h-screen bg-gray-100">

            <div class="flex flex-1 overflow-hidden">
                <nav class="w-64 p-4 bg-white">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}"
                                class="block p-2 text-gray-800 transition duration-200 rounded hover:text-white hover:bg-gray-600">Home</a>
                        </li>
                        <li class="mt-2">
                            <p class="font-semibold text-gray-800">User Management</p>
                        </li>
                        <li><a href="{{ route('admin.users.index') }}"
                                class="block p-2 text-gray-800 transition duration-200 rounded hover:text-white hover:bg-gray-600">Users</a>
                        </li>
                        <li><a href="{{ route('admin.drivers.index') }}"
                                class="block p-2 text-gray-800 transition duration-200 rounded hover:text-white hover:bg-gray-600">Drivers</a>
                        </li>
                        <li><a href="{{ route('admin.admins.index') }}"
                                class="block p-2 text-gray-800 transition duration-200 rounded hover:text-white hover:bg-gray-600">Admins</a>
                        </li>
                        <li class="mt-2">
                            <p class="font-semibold text-gray-800">Product Management</p>
                        </li>
                        <li><a href="{{ route('admin.products.index') }}"
                                class="block p-2 text-gray-800 transition duration-200 rounded hover:text-white hover:bg-gray-600">Products</a>
                        </li>
                    </ul>
                </nav>
                <main class="flex-1 p-4 overflow-y-scroll">
                    {{ $slot }}
                </main>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    @stack('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
</body>

</html>
