<?php

namespace App\Console\Commands;

use App\Models\Employe;
use Illuminate\Console\Command;

class UpdateStatutEmploye extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-statut';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mettre à jour le statut des employés en absence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mise à jour du statut des employés en cours...');

        $employesEnAbsenceOuConge = Employe::whereHas('demandesAbsence', function ($query) {
            $query->where('statut', 'approuvee')
                  ->where('date_debut', today());
        })
        ->orWhereHas('conges', function ($query) {
            $query->where('date_debut', today());
        })
        ->get();

        foreach ($employesEnAbsenceOuConge as $employe) {
            $employe->statut = 'absent';
            $employe->save();
        }

        $this->info('Mise à jour terminée. Les employés en absence ou en congé ont été marqués comme tels.');
    }
}