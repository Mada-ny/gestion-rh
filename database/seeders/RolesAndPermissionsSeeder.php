<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        Permission::create(['name' => 'voir ses infos']); //voir ses infos
        Permission::create(['name' => 'créer absence']); //créer une demande d'absence
        Permission::create(['name' => 'voir ses absences']); //voir ses demandes d'absence
        Permission::create(['name' => 'voir calendrier']); //voir le calendrier des congés

        Permission::create(['name' => 'gérer employés']); //gérer les employés 
        Permission::create(['name' => 'voir employés']); //voir la liste des employés
        Permission::create(['name' => 'gérer congés']); //gerer les congés
        Permission::create(['name' => 'voir congés']); //voir la liste des congés
        Permission::create(['name' => 'gérer absences']); //gérer les absences
        Permission::create(['name' => 'voir absences']); //voir la liste des absences
        Permission::create(['name' => 'gérer départements']); //gerer les départements
        Permission::create(['name' => 'voir départements']); //voir la liste des départements
        Permission::create(['name' => 'approuver absences']); //approuver les absences

        // Créer les rôles et assigner les permissions
        $roleEmploye = Role::create(['name' => 'employe']);
        $roleEmploye->givePermissionTo([
            'voir ses infos',
            'créer absence',
            'voir ses absences',
            'voir calendrier',
            'voir congés'
        ]);

        $roleDRH = Role::create(['name' => 'drh']);
        $roleDRH->givePermissionTo([
            'gérer employés',
            'voir employés',
            'gérer congés',
            'voir congés',
            'voir absences',
            'voir ses infos',
            'gérer départements',
            'voir départements'
        ]);

        $roleDirecteur = Role::create(['name' => 'directeur']);
        $roleDirecteur->givePermissionTo([
            'voir ses infos',
            'voir employés',
            'voir congés',
            'voir absences',
            'approuver absences',
            'voir départements'
        ]);
    }
}