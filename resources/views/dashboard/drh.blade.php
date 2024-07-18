@extends('layouts.app')

@section('title', 'Dashboard DRH')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard DRH</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-semibold mb-4">Statistiques</h2>
            <p class="mb-2">Nombre total d'employés : <span class="font-bold">{{ $totalEmployes }}</span></p>
            <p>Employés en congé : <span class="font-bold">{{ $employesEnConge }}</span></p>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
            <div class="space-y-4">
                <a href="{{ route('employes.create') }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    Ajouter un nouvel employé
                </a>
                <a href="{{ route('employes.index') }}" class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    Gérer les employés
                </a>
                <a href="{{ route('employes.export') }}" class="block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                    Exporter la liste des employés
                </a>
            </div>
        </div>
    </div>
@endsection