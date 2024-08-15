<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __( 'Demande d\'absence' ) }}
            </h2>
            <a href="{{ route('absences.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    <h3 class="text-2xl font-semibold mb-4">{{ $absence->employe->prénom }} {{ $absence->employe->nom }}</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <p class="text-xl"><strong>Date de début :</strong> {{ $absence->date_debut->format('d/m/Y') }}</p>
                        <p class="text-xl"><strong>Date de fin :</strong> {{ $absence->date_fin->format('d/m/Y') }}</p>
                        <p class="text-xl"><strong>Motif :</strong> {{ $absence->motif }}</p>
                        <p class="text-xl"><strong>Statut :</strong>
                            @if($absence->statut == 'en_attente')
                                <span class="px-1 text-xl leading-5 font-semibold text-yellow-800">
                                    En attente
                                </span>
                            @elseif($absence->statut == 'approuvee')
                                <span class="px-1 text-xl leading-5 font-semibold text-green-800">
                                    Approuvée
                                </span>
                            @else
                                <span class="px-1 text-xl leading-5 font-semibold text-red-800">
                                    Refusée
                                </span>
                            @endif
                        </p>
                    </div>

                    @can('approuver absences')
                    <div class="mt-4 flex justify-end">
                        <form action="{{ route('absences.approve', $absence) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Approuver
                            </button>
                        </form>
                        <form action="{{ route('absences.reject', $absence) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Refuser
                            </button>
                        </form>
                    </div>
                    @endcan

                    @can('créer absence')
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('absences.edit', $absence) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Modifier
                        </a>
                        <form action="{{ route('absences.destroy', $absence) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</x-app-layout>