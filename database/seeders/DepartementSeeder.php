<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departements = [
            'Direction générale',
            'Ressources humaines',
            'Secrétariat',
            'Informatique',
            'Comptabilité',
            'Marketing',
        ];

        foreach ($departements as $nom) {
            Departement::create([
                'nom' => $nom,
            ]);
        }
    }
}