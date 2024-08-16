<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Créer la fiche de l'employé" type="submit" class="btn-success" icon="o-plus-circle" />
    {{ $slot }}
</button>