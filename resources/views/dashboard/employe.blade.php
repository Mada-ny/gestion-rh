@extends('layouts.app')

@section('title', 'Dashboard Employé')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Bienvenue, {{ Auth::user()->name }}</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-xl font-semibold mb-4">Mes dernières demandes d'absence</h2>
        @if($demandes->count() > 0)
            <ul>
                @foreach($demandes as $demande)
                    <li class="mb-2">
                        <span class="font-medium">{{ $demande->date_debut->format('d/m/Y') }} - {{ $demande->date_fin->format('d/m/Y') }}</span>
                        <span class="ml-2 px-2 py-1 rounded text-sm 
                            @if($demande->statut == 'en_attente') bg-yellow-200 text-yellow-800
                            @elseif($demande->statut == 'approuvee') bg-green-200 text-green-800
                            @else bg-red-200 text-red-800 @endif">
                            {{ ucfirst($demande->statut) }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune demande d'absence récente.</p>
        @endif
    </div>
