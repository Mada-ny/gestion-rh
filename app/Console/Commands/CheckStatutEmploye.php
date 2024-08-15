<?php

namespace App\Console\Commands;

use App\Models\DemandeAbsence;
use App\Models\Conge;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckStatutEmploye extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-statut';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier le statut des employés et les remettre en activité si nécessaire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification du statut des employés en cours...');

        $today = Carbon::today();
        $absences = DemandeAbsence::where('statut', 'approuvee')
            ->where('date_fin', '<', $today)
            ->get();

        $conges = Conge::where('date_fin', '<', $today)->get();
        
        foreach ($absences as $absence) {
            $absence->employe->statut = 'actif';
            $absence->employe->save();
        }

        foreach ($conges as $conge) {
            $conge->employe->statut = 'actif';
            $conge->employe->save();
        }

        $this->info('Vérification terminée. Les employés qui sont de retour ont été réactivés.');
    }
}