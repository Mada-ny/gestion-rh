<x-app-layout>
    <x-mary-header title="Modifier les informations de l'employé" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('employes.index') }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
        <form action="{{ route('employes.update', $employe) }}" method="POST">
            <x-card class="p-6 shadow-lg">
                @csrf
                @method('PUT')
                <div class="flex flex-col w-full gap-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="prénom" :value="__('Prénom')" class="text-info" />
                            <x-text-input id="prénom" name="prénom" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('prénom', $employe->prénom)" required autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('prénom')" />
                        </div>
                        <div>
                            <x-input-label for="nom" :value="__('Nom')" class="text-info" />
                            <x-text-input id="nom" name="nom" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('nom', $employe->nom)" required autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <x-input-label for="email" :value="__('Email')" class="text-info" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('email', $employe->email)" required autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label for="sexe" :value="__('Sexe')" class="text-info" />
                                <select id="sexe" name="sexe" class="mt-1 block w-full bg-base-300 border-info focus:bg-secondary focus:outline-none focus:border-primary focus:ring-primary rounded-md" required>
                                    <option value="" selected disabled>Sélectionnez le sexe</option>
                                    <option value="masculin" {{ old('sexe', $employe->sexe) == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="féminin" {{ old('sexe', $employe->sexe) == 'féminin' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            <x-input-error class="mt-2" :messages="$errors->get('sexe')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="departement_id" :value="__('Département')" class="text-info" />
                                <select id="departement_id" name="departement_id" class="mt-1 block w-full bg-base-300 border-info focus:bg-secondary focus:outline-none focus:border-primary focus:ring-primary rounded-md" required>
                                    <option value="" selected disabled>Sélectionnez le département de l'employé</option>
                                        @foreach($departements as $departement)
                                            <option value="{{ $departement->id }}" {{ old('departement_id', $employe->departement_id) == $departement->id ? 'selected' : '' }}>
                                                {{ $departement->nom }}
                                            </option>
                                        @endforeach
                                </select>
                            <x-input-error class="mt-2" :messages="$errors->get('departement_id')" />
                        </div>
                        <div>
                            <x-input-label for="poste" :value="__('Poste')" class="text-info" />
                            <x-text-input id="poste" name="poste" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('poste', $employe->poste)" required autocomplete="off" />
                            <x-input-error class="mt-2" :messages="$errors->get('poste')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="lieu_habitation" :value="__('Lieu d\'habitation')" class="text-info" />
                        <x-text-input id="lieu_habitation" name="lieu_habitation" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('lieu_habitation', $employe->lieu_habitation)" required autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('lieu_habitation')" />
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="date_naissance" :value="__('Date de naissance')" class="text-info" />
                            <x-text-input id="date_naissance" name="date_naissance" type="date" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('date_naissance', $employe->date_naissance->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_naissance')" />
                        </div>
                        <div>
                            <x-input-label for="date_embauche" :value="__('Date d\'embauche')" class="text-info" />
                            <x-text-input id="date_embauche" name="date_embauche" type="date" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('date_embauche', $employe->date_embauche->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_embauche')" />
                        </div>
                        <div>
                            <x-input-label for="statut" :value="__('Statut')" class="text-info" />
                            <select id="statut" name="statut" class="mt-1 block w-full bg-base-300 border-info focus:outline-none focus:bg-secondary focus:border-primary focus:ring-primary rounded-md" required>
                                <option value="actif" {{ old('statut', $employe->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="absent" {{ old('statut', $employe->statut) == 'absent' ? 'selected' : '' }}>Absent</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('statut')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="contact" :value="__('Contact')" class="text-info" />
                            <x-text-input id="contact" name="contact" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('contact', $employe->contact)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
                        </div>
                        <div>
                            <x-input-label for="nationalité" :value="__('Nationalité')" class="text-info" />
                            <x-text-input id="nationalité" name="nationalité" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('nationalité', $employe->nationalité)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nationalité')" />
                        </div>
                    </div>
                </div>
            </x-card>

            <div class="flex justify-center mt-8">
                <x-mary-button label="Appliquer les modifications" type="submit" class="btn-success" icon="o-check-circle" />
            </div>
        </form>
    </div>
</x-app-layout>