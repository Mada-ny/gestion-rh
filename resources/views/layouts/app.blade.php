<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title') - Gestion des Congés et Absences</title>
        
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
        <nav class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-lg font-bold">GestionRH</a>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="mr-4">Dashboard</a>
                        <a href="{{ route('demande-absences.index') }}" class="mr-4">Demandes d'absence</a>
                        <a href="{{ route('profile') }}" class="mr-4">Profil</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 px-4 py-2 rounded">Déconnexion</button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>
    
        <main class="container mx-auto mt-6 p-4">
            @yield('content')
        </main>
    
        <footer class="bg-gray-200 text-center p-4 mt-8">
            <p>&copy; {{ date('Y') }} GestionRH. Tous droits réservés.</p>
        </footer>
    </body>
</html>
