@extends('layouts.app')

@section('title', 'Demandes d\'absence')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Demandes d'absence</h1>

    @if($demandes->count() > 0)
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <table class="w-full">
                <thead>
                    <tr>
                        @if($role === 'directeur')
                            <th class="text-left">Employé</th>
                        @endif
                        <th class="text-left">Date de début</th>
                        <th class="text-left">Date de fin</th>
                        <th class="text-left">Motif</th>
                        <th class="text-left">Statut</th>
                        @if($role === 'directeur')
                            <th class="text-left">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                        <tr>
                            @if($role === 'directeur')
                                <td>{{ $demande->employe->nom }} {{ $demande->employe->prenom }}</td>
                            @endif
                            <td>{{ $demande->date_debut->format('d/m/Y') }}</td>
                            <td>{{ $demande->date_fin->format('d/m/Y') }}</td>
                            <td>{{ $demande->motif }}</td>
                            <td>
                                <span class="px-2 py-1 rounded text-sm 
                                    @if($demande->statut == 'en_attente') bg-yellow-200 text-yellow-800
                                    @elseif($demande->statut == 'approuvee') bg-green-200 text-green-800
                                    @else bg-red-200 text-red-800 @endif">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            @if($role === 'directeur' && $demande->statut === 'en_attente')
                                <td>
                                    <form action="{{ route('demande-absences.approve', $demande) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs">Approuver</button>
                                    </form>
                                    <form action="{{ route('demande-absences.reject', $demande) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs">Rejeter</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $demandes->links() }}
    @else
        <p>Aucune demande d'absence trouvée.</p>
    @endif
@endsection