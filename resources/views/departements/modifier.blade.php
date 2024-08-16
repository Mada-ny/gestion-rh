<x-app-layout>
    <x-mary-header title="Modifier département : {{ $departement->nom }}" class="font-serif font-semibold text-3xl max-w-7xl mx-auto mb-auto py-6 px-4 sm:px-6 lg:px-8 leading-tight text-primary" separator>
        <x-slot:actions>
            <x-button label="Retour" icon="o-arrow-left" class="btn-outline btn-primary font-semibold" link="{{ url()->previous() }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-40">
        <form action="{{ route('departements.update', $departement) }}" method="POST">
            <x-card class="p-6 shadow-lg">
                @csrf
                @method('PUT')
                <div class="flex flex-col w-full">
                    <div>
                        <x-input-label for="nom" :value="__('Nom du département')" class="text-info" />
                        <x-text-input id="nom" name="nom" type="text" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" :value="old('nom', $departement->nom)" required autocomplete="off" />
                        <x-input-error class="mt-2" :messages="$errors->get('nom')" />
                    </div>
                </div>
            </x-card>
            
            <div class="flex justify-center mt-8">
                <x-mary-button label="Appliquer les modifications" type="submit" class="btn-success" icon="o-check-circle" />
            </div>
        </form>
    </div>
</x-app-layout>
