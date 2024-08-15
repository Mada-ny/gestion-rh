<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier les détails de l\'absence') }}
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
                    <form action="{{ route('absences.update', $absence) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="date_debut" :value="__('Date de début')" />
                                <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block w-3/6" :value="old('date_debut', $absence->date_debut->format('Y-m-d'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('date_debut')" />
                            </div>
                            <div>
                                <x-input-label for="date_fin" :value="__('Date de fin')" />
                                <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block w-3/6" :value="old('date_fin', $absence->date_fin->format('Y-m-d'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('date_fin')" />
                            </div>
                            <div>
                                <x-input-label for="motif" :value="__('Motif')" />
                                <textarea id="motif" name="motif" class="mt-1 block w-3/6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('motif', $absence->motif) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('motif')" />
                            </div>
                        </div>
                        <div class="flex items-center justify-start mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Appliquer les modifications') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
