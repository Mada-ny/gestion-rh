<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Ajouter la période" type="submit" class="btn-success" icon="o-plus-circle" />
    {{ $slot }}
</button>