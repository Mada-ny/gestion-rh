<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Directeur
        $directeurUser = User::create([
            'prénom' => 'Cheick',
            'nom' => 'Doumbia',
            'email' => 'madanydoumbia09@gmail.com',
            'password' => Hash::make('1234567890')
        ]);
        
        Employe::create([
            'prénom' => 'Cheick',
            'nom' => 'Doumbia',
            'email' => 'madanydoumbia09@gmail.com',
            'sexe' => 'masculin',
            'poste' => 'Directeur Général',
            'departement_id' => 1,
            'contact' => '0747064296',
            'date_naissance' => '2004-09-04',
            'date_embauche' => '2023-01-01',
            'statut' => 'actif',
            'lieu_habitation' => 'Yopougon Maroc, Abidjan',
            'nationalité' => 'Ivoirienne',
            'user_id' => $directeurUser->id,
        ]);

        $directeurUser->assignRole('directeur');


        //DRH
        $drhUser = User::create([
            'prénom' => 'Noura',
            'nom' => 'Doumbia',
            'email' => 'nouradoumbia29@gmail.com',
            'password' => Hash::make('1234567890')
        ]);
        
        Employe::create([
            'prénom' => 'Noura',
            'nom' => 'Doumbia',
            'email' => 'nouradoumbia29@gmail.com',
            'sexe' => 'féminin',
            'poste' => 'Directrice des Ressources Humaines',
            'departement_id' => 2,
            'contact' => '0511223344',
            'date_naissance' => '2004-01-01',
            'date_embauche' => '2023-01-01',
            'statut' => 'actif',
            'lieu_habitation' => 'Yopougon Maroc, Abidjan',
            'nationalité' => 'Ivoirienne',
            'user_id' => $drhUser->id,
        ]);

        $drhUser->assignRole('drh');
    }
}