<x-app-layout>
    <x-mary-header title="Nouvelle période de congés" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('conges.index') }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
        <form action="{{ route('conges.store') }}" method="POST">
            <x-card class="p-6 shadow-lg">
                @csrf
                <div class="flex flex-col w-full gap-6">
                    <div>
                        <x-input-label for="employe_id" :value="__('Employé')" class="text-info" />
                        <select id="employe_id" name="employe_id" class="mt-1 block w-full bg-base-300 border-info focus:bg-secondary focus:outline-none focus:border-primary focus:ring-primary rounded-md" required>
                            <option value="" selected disabled>Choisir un employé</option>
                            @foreach ($employes as $employe)
                                <option value="{{ $employe->id }}">{{ $employe->nom }} {{ $employe->prénom }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('employe_id')" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="date_debut" :value="__('Date de début')" class="text-info" />
                            <x-text-input id="date_debut" name="date_debut" type="date" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('date_debut')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_debut')" />
                        </div>
                        <div>
                            <x-input-label for="date_fin" :value="__('Date de fin')" class="text-info" />
                            <x-text-input id="date_fin" name="date_fin" type="date" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('date_fin')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date_fin')" />
                        </div>
                    </div>
                </div>
            </x-card>
            
            <div class="flex justify-center mt-8">
                <x-conge-button>
                </x-conge-button>
            </div>
        </form>
    </div>
</x-app-layout>
