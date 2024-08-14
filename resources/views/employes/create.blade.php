<x-app-layout>
    <x-mary-header title="Ajouter un nouvel employé" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('employes.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="prénom" :value="__('Prénom')" />
                                <x-text-input id="prénom" name="prénom" type="text" class="mt-1 block w-full" :value="old('prénom')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('prénom')" />
                            </div>
                            <div>
                                <x-input-label for="nom" :value="__('Nom')" />
                                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                            <div>
                                <x-input-label for="sexe" :value="__('Sexe')" />
                                <select id="sexe" name="sexe" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" selected disabled>Sélectionnez le sexe</option>
                                    <option value="masculin" {{ old('sexe') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="féminin" {{ old('sexe') == 'féminin' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('sexe')" />
                            </div>
                            <div>
                                <x-input-label for="poste" :value="__('Poste')" />
                                <x-text-input id="poste" name="poste" type="text" class="mt-1 block w-full" :value="old('poste')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('poste')" />
                            </div>
                            <div>
                                <x-input-label for="departement_id" :value="__('Département')" />
                                <select id="departement_id" name="departement_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" selected disabled>Sélectionnez le département de l'employé</option>
                                    @foreach($departements as $departement)
                                        <option value="{{ $departement->id }}" {{ old('departement_id') == $departement->id ? 'selected' : '' }}>
                                            {{ $departement->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('departement_id')" />
                            </div>
                            <div>
                                <x-input-label for="contact" :value="__('Contact')" />
                                <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                            </div>
                            <div>
                                <x-input-label for="lieu_habitation" :value="__('Lieu d\'habitation')" />
                                <x-text-input id="lieu_habitation" name="lieu_habitation" type="text" class="mt-1 block w-full" :value="old('lieu_habitation')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lieu_habitation')" />
                            </div>
                            <div>
                                <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                                <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block w-full" :value="old('date_naissance')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date_naissance')" />
                            </div>
                            <div>
                                <x-input-label for="date_embauche" :value="__('Date d\'embauche')" />
                                <x-text-input id="date_embauche" name="date_embauche" type="date" class="mt-1 block w-full" :value="old('date_embauche')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date_embauche')" />
                            </div>
                            <div>
                                <x-input-label for="nationalité" :value="__('Nationalité')" />
                                <x-text-input id="nationalité" name="nationalité" type="text" class="mt-1 block w-full" :value="old('nationalité')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nationalité')" />
                            </div>
                            <div>
                                <x-input-label for="statut" :value="__('Statut')" />
                                <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="absent" {{ old('statut') == 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('statut')" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('employes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                {{ __('Retour') }}
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Créer l\'employé') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>