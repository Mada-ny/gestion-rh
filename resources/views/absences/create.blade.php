<x-app-layout>
    <x-mary-header title="Nouvelle demande d'absence" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ route('absences.index') }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
        <form action="{{ route('absences.store') }}" method="POST">
            <x-card class="p-6 shadow-lg">
                @csrf
                <div class="flex flex-col w-full gap-6">
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
                    <div>
                        <x-input-label for="motif" :value="__('Motif')" class="text-info" />
                        <textarea id="motif" name="motif" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary rounded-md" required>{{ old('motif') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('motif')" />
                    </div>
                </div>
            </x-card>
            
            <div class="flex justify-center mt-8">
                <x-absence-button>
                </x-absence-button>
            </div>
        </form>
    </div>
</x-app-layout>
