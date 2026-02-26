<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Barroc Intens.</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">

<!-- Jouw zachte gele achtergrond -->
<div class="min-h-screen bg-yellow-50">
    <div class="mx-auto flex min-h-screen max-w-2xl flex-col items-center justify-center px-4 py-10">

        <!-- Brand -->
        <header class="mb-10 flex flex-col items-center">
            <a href="{{ route('index') }}"
               class="group flex items-center gap-3 transition focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 rounded-lg px-2 py-1">

                <img src="{{ asset('images/logo5_klein.png') }}"
                     alt="Barroc Intens Logo"
                     class="h-9 w-auto">

                <span class="text-2xl font-semibold">
                    <span class="text-yellow-500">Barroc</span>
                    <span class="text-black">Intens.</span>
                </span>
            </a>

            <p class="mt-3 text-sm text-gray-600">
                Bedankt dat je even de tijd neemt 🙏
            </p>
        </header>

        <!-- Card -->
        <main class="w-full max-w-lg">
            <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-yellow-200">

                <!-- Gele accent bar -->
                <div class="h-1.5 bg-yellow-500"></div>

                <div class="px-6 py-8 sm:px-8">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center text-xs text-gray-600">
                © {{ date('Y') }} Barroc Intens.
            </footer>
        </main>

    </div>
</div>

</body>
</html>
