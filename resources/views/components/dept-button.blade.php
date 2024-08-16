<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Créer le département" type="submit" class="btn-success" icon="o-plus-circle" />
    {{ $slot }}
</button>