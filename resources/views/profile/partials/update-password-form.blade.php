<section>
    <header>
        <h2 class="text-2xl font-bold text-primary">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-base text-info">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-info" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-info" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-info" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block border-info w-full bg-base-300 focus:bg-secondary focus:ring-primary focus:border-primary" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-mdp-button></x-mdp-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-primary"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
