<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.min.css' rel='stylesheet' />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    </head>

    <body class="flex flex-col min-h-screen bg-base-200 font-sans antialiased">
        <div class="flex-grow">
            @include('layouts.nav')

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

        </div>
        <footer class="bg-base-100 text-center p-4 mt-5">
            <p>&copy; {{ date('Y') }} MyPMEAbsences. Tous droits réservés.</p>
        </footer>
    </body>
</html>
