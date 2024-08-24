<x-nav sticky full-width>
    <x-slot:brand>
        <x-icon name="o-calendar-date-range" class="mr-2"/>
        <h1 class="font-bold">MyPME-Absences</h1>
    </x-slot:brand>

    <x-slot:actions>
        <x-mary-button label="Accueil" class="btn-ghost btn-sm" icon="o-home" link="{{ route('dashboard') }}" responsive />

        @role('employe')
            <x-mary-button label="Mes Infos" icon="o-identification" class="btn-ghost btn-sm" link="{{ route('employes.show', Auth::user()->employe) }}" responsive />
            <x-mary-button label="Absences" class="btn-ghost btn-sm" icon="o-clock" link="{{ route('absences.index') }}" responsive />
        @endrole

        @role('directeur|drh')
                <x-mary-button label="Employés" icon="o-user-group" class="btn-ghost btn-sm" link="{{ route('employes.index') }}" responsive />
                <x-mary-button label="Absences" class="btn-ghost btn-sm" icon="o-clock" link="{{ route('absences.index') }}" responsive />
                <x-mary-button label="Départements" icon="o-building-office-2" class="btn-ghost btn-sm" link="{{ route('departements.index') }}" responsive />
        @endrole

        <x-mary-button label="Congés" icon="o-arrow-right-on-rectangle" class="btn-ghost btn-sm" link="{{ route('conges.index') }}" responsive/>

        <x-dropdown no-x-anchor right>
                <x-slot:trigger>
                   <x-mary-button label="{{ Auth::user()->prénom }}" icon="o-user" class="btn-ghost btn-sm focus:bg-secondary" responsive />
                </x-slot:trigger>
            <x-menu-item title="Mot de passe" icon="o-key" link="{{ route('profile.edit') }}" />
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-menu-item title="{{ __('Log Out') }}" icon="o-power" onclick="event.preventDefault();this.closest('form').submit();"/>
            </form>
        </x-dropdown>
    </x-slot:actions>
</x-nav>