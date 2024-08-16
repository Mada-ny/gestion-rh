<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Lien de réinitialisation du mot de passe" icon="o-arrow-path" type="submit" class="text-info btn-accent btn-sm" />
    {{ $slot }}
</button>