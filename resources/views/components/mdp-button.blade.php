<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Sauvegarder" type="submit" class="btn-primary" icon="o-check-circle" />
    {{ $slot }}
</button>