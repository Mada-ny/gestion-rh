@extends('layouts.app')

@section('title', 'Dashboard Directeur')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard Directeur</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-semibold mb-4">Statistiques des demandes d'absence</h2>
            <p class="mb-2">En attente : <span class="font-bold text-yellow-600">{{ $demandesEnAttente }}</span></p>
            <p class="mb-2">Approuvées : <span class="font-bold text-green-600">{{ $demandesApprouvees }}</span></p>
            <p>Refusées : <span class="font-bold text-red-600">{{ $demandesRefusees }}</span></p>
        </div>

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-semibold mb-4">Dernière demande d'absence</h2>
            @if($derniereDemande)
                <p class="mb-2">Employé : <span class="font-bold">{{ $derniereDemande->employe->nom }} {{ $derniereDemande->employe->prenom }}</span></p>
                <p class="mb-2">Date : {{ $derniereDemande->date_debut->format('d/m/Y') }} - {{ $derniereDemande->date_fin->format('d/m/Y') }}</p>
                <p class="mb-2">Statut : 
                    <span class="px-2 py-1 rounded text-sm 
                        @if($derniereDemande->statut == 'en_attente') bg-yellow-200 text-yellow-800
                        @elseif($derniereDemande->statut == 'approuvee') bg-green-200 text-green-800
                        @else bg-red-200 text-red-800 @endif">
                        {{ ucfirst($derniereDemande->statut) }}
                    </span>
                </p>
                <div class="mt-4">
                    <a href="{{ route('demande-absences.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Voir toutes les demandes
                    </a>
                </div>
            @else
                <p>Aucune demande d'absence récente.</p>
            @endif
        </div>
    </div>
@endsection