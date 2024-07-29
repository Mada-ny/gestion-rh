@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Liste des congés</h1>
    <a href="{{ route('conges.create') }}" class="btn btn-primary mb-3">Ajouter un congé</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conges as $conge)
            <tr>
                <td>{{ $conge->employe->nom }} {{ $conge->employe->prenom }}</td>
                <td>{{ $conge->date_debut }}</td>
                <td>{{ $conge->date_fin }}</td>
                <td>
                    <a href="{{ route('conges.show', $conge) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('conges.edit', $conge) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('conges.destroy', $conge) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce congé ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $conges->links() }}
</div>
@endsection