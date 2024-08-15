<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'employé') }}
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
                    <form action="{{ route('employes.update', $employe) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="prénom" :value="__('Prénom')" />
                                <x-text-input id="prénom" name="prénom" type="text" class="mt-1 block w-full" :value="old('prénom', $employe->prénom)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('prénom')" />
                            </div>
                            <div>
                                <x-input-label for="nom" :value="__('Nom')" />
                                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $employe->nom)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $employe->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div>
                                <x-input-label for="sexe" :value="__('Sexe')" />
                                <select id="sexe" name="sexe" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" selected disabled>Sélectionnez le sexe</option>
                                    <option value="masculin" {{ old('sexe', $employe->sexe) == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="féminin" {{ old('sexe', $employe->sexe) == 'féminin' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('sexe')" />
                            </div>
                            <div>
                                <x-input-label for="poste" :value="__('Poste')" />
                                <x-text-input id="poste" name="poste" type="text" class="mt-1 block w-full" :value="old('poste', $employe->poste)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('poste')" />
                            </div>
                            <div>
                                <x-input-label for="departement_id" :value="__('Département')" />
                                <select id="departement_id" name="departement_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($departements as $departement)
                                        <option value="{{ $departement->id }}" {{ old('departement_id', $employe->departement_id) == $departement->id ? 'selected' : '' }}>
                                            {{ $departement->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('departement_id')" />
                            </div>
                            <div>
                                <x-input-label for="contact" :value="__('Contact')" />
                                <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact', $employe->contact)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                            </div>
                            <div>
                                <x-input-label for="lieu_habitation" :value="__('Lieu d\'habitation')" />
                                <x-text-input id="lieu_habitation" name="lieu_habitation" type="text" class="mt-1 block w-full" :value="old('lieu_habitation', $employe->lieu_habitation)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lieu_habitation')" />
                            </div>
                            <div>
                                <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                                <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full" :value="old('date_naissance', $employe->date_naissance->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date_naissance')" />
                            </div>
                            <div>
                                <x-input-label for="date_embauche" :value="__('Date d\'embauche')" />
                                <x-text-input id="date_embauche" name="date_embauche" type="date" class="mt-1 block w-full" :value="old('date_embauche', $employe->date_embauche->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date_embauche')" />
                            </div>
                            <div>
                                <x-input-label for="nationalité" :value="__('Nationalité')" />
                                <x-text-input id="nationalité" name="nationalité" type="text" class="mt-1 block w-full" :value="old('nationalité', $employe->nationalité)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nationalité')" />
                            </div>
                            <div>
                                <x-input-label for="statut" :value="__('Statut')" />
                                <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="actif" {{ old('statut', $employe->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="absent" {{ old('statut', $employe->statut) == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="inactif" {{ old('statut', $employe->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('statut')" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
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