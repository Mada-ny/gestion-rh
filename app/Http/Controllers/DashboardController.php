<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;
use App\Models\DemandeAbsence;
use App\Models\Employe;

class DashboardController extends Controller
{
    public function index(Request $request) 
    {
        $user = $request->user();
        $role = $user->employe->role->nom;

        switch ($role) {
            case 'employe':
                $demandes = $user->employe->demandeAbsences()->latest()->take(5)->get();
                return view('dashboard.employe', compact('demandes'));
            case 'drh':
                $totalEmployes = Employe::count();
                $employesEnConge = Employe::whereHas('conge', function ($query) {
                    $query->whereDate('date_debut', '<=', now())
                          ->whereDate('date_fin', '>=', now());
                })->count();
                return view('dashboard.drh', compact('totalEmployes', 'employesEnConge'));
            case 'directeur':
                $demandesEnAttente = DemandeAbsence::where('statut', 'en_attente')->count();
                $demandesApprouvees = DemandeAbsence::where('statut', 'approuvee')->count();
                $demandesRefusees = DemandeAbsence::where('statut', 'refusee')->count();
                $derniereDemande = DemandeAbsence::latest()->first();
                return view('dashboard.directeur', compact('demandesEnAttente', 'demandesApprouvees', 'demandesRefusees', 'derniereDemande'));
            default:
                return redirect()->route('login');
        }
    }
}