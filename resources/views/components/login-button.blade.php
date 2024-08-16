<button {{ $attributes->merge(['type' => 'submit']) }}>
    <x-mary-button label="Se connecter" icon="o-arrow-right-end-on-rectangle" type="submit" class="text-info btn-accent btn-sm" />
    {{ $slot }}
</button>