<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employe;
use App\Models\Role;
use App\Models\Departement;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $roleDirecteur = Role::updateOrCreate(['nom' => 'Directeur']);
        $roleDRH = Role::updateOrCreate(['nom' => 'DRH']);

        // Création du département RH
        $departementRH = Departement::updateOrCreate(['nom' => 'Ressources Humaines']);
        $departementDirecteur = Departement::updateOrCreate(['nom' => 'Direction']);

        // Création du compte Directeur
        $userDirecteur = User::updateOrCreate([
            'name' => 'Doumbia Cheick',
            'email' => 'directeur@example.com',
            'password' => '0123456789',
        ]);

        Employe::updateOrCreate([
            'nom' => 'Doumbia',
            'prenom' => 'Cheick',
            'email' => 'directeur@example.com',
            'poste' => 'Directeur Général',
            'date_naissance' => '1970-01-01',
            'date_embauche' => '2000-01-01',
            'sexe' => 'Homme',
            'nationalite' => 'Ivoirien',
            'lieu_habitation' => 'Abidjan',
            'contact' => '0123456789',
            'statut' => 'Actif',
            'departement_nom' => $departementDirecteur->nom,
            'user_id' => $userDirecteur->id,
            'departement_id' => $departementDirecteur->id,
            'role_id' => $roleDirecteur->id,
        ]);

        // Création du compte DRH
        $userDRH = User::updateOrCreate([
            'name' => 'Ouattara Fatim',
            'email' => 'drh@example.com',
            'password' => '0123456789',
        ]);

        Employe::updateOrCreate([
            'nom' => 'Ouattara',
            'prenom' => 'Fatim',
            'email' => 'drh@example.com',
            'poste' => 'Directrice des Ressources Humaines',
            'date_naissance' => '1980-01-01',
            'date_embauche' => '2010-01-01',
            'sexe' => 'Femme',
            'nationalite' => 'Ivoirienne',
            'lieu_habitation' => 'Abidjan',
            'contact' => '0987654321',
            'statut' => 'Actif',
            'departement_nom' => $departementRH->nom,
            'user_id' => $userDRH->id,
            'departement_id' => $departementRH->id,
            'role_id' => $roleDRH->id,
        ]);
    }
}