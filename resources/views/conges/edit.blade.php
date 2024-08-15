<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modification congés : {{ $conge->employe->nom }} {{ $conge->employe->prénom }}
        </h2>
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
                    <form action="{{ route('conges.update', $conge) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="date_debut" :value="__('Date de début')" />
                                <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-3/6" :value="old('date_debut', $conge->date_debut->format('Y-m-d'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('date_debut')" />
                            </div>
                            <div>
                                <x-input-label for="date_fin" :value="__('Date de fin')" />
                                <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-3/6" :value="old('date_fin', $conge->date_fin->format('Y-m-d'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('date_fin')" />
                            </div>
                        </div>
                        <div class="flex items-center justify-start mt-4">
                            <x-primary-button class="mt-4">
                                {{ __('Mettre à jour') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
