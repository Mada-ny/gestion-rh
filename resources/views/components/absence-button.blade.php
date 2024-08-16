<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Soumettre la demande d'absence" type="submit" class="btn-success" icon="o-plus-circle" />
    {{ $slot }}
</button>