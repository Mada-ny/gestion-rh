<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeAbsence;
use App\Models\Employe;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = auth()->user();

        switch ($user->role->nom) {
            case 'Employé':
                return $this->employeDashboard($user);
            case 'DRH':
                return $this->drhDashboard();
            case 'Directeur':
                return $this->directeurDashboard();
            default:
                return view('dashboard.default');
        }
    }

    private function employeDashboard($employe)
    {
        $demandesEnCours = $employe->demandeAbsences()->where('statut', 'en_attente')->count();

        $conges = $employe->conges()
                ->whereYear('date_debut', now()->year)
                ->whereYear('date_fin', now()->year)
                ->get();

        $periodeConges = [
            'debut' => $conges->min('date_debut'),
            'fin' => $conges->max('date_fin')
        ];

        return view('dashboard.employe', compact('demandesEnCours', 'periodeConges'));
    }

    private function drhDashboard()
    {
        $totalEmployes = Employe::count();
        $demandesEnAttente = DemandeAbsence::where('statut', 'en_attente')->count();
        
        return view('dashboard.drh', compact('totalEmployes', 'demandesEnAttente'));
    }

    private function directeurDashboard()
    {
        $demandesEnAttente = DemandeAbsence::where('statut', 'en_attente')->count();
        $demandesAcceptees = DemandeAbsence::where('statut', 'approuvee')->count();
        $demandesRefusees = DemandeAbsence::where('statut', 'refusee')->count();
        $derniereDemande = DemandeAbsence::latest()->first();
        
        return view('dashboard.directeur', compact('demandesEnAttente', 'demandesAcceptees', 'demandesRefusees', 'derniereDemande'));
    }
    
}