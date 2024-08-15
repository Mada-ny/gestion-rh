<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employe;
use App\Models\DemandeAbsence;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('employe')) {
            $totalDemandes = DemandeAbsence::where('employe_id', $user->employe->id)->count();
            $data['total_demandes'] = $totalDemandes;

            $derniereDemande = DemandeAbsence::where('employe_id', $user->employe->id)
                ->latest()->first();
            $data['derniere_demande'] = $derniereDemande ?? null;

            $demandesEnCours = DemandeAbsence::where('employe_id', $user->employe->id)
                ->where('statut', 'en_attente')->count();
            $data['demandes_en_cours'] = $demandesEnCours;
        } elseif ($user->hasRole('drh')) {
            $totalEmployes = Employe::count();
            $data['total_employes'] = $totalEmployes;

            $employesEnConge = Employe::where('statut', 'absent')->count();
            $data['employes_en_conge'] = $employesEnConge;
        } elseif ($user->hasRole('directeur')) {
            $demandesEnAttente = DemandeAbsence::where('statut', 'en_attente')->count();
            $data['demandes_en_attente'] = $demandesEnAttente;

            $derniereDemande = DemandeAbsence::with('employe')->latest()->first();
            $data['derniere_demande'] = $derniereDemande ?? null;

            $demandesApprouvees = DemandeAbsence::where('statut', 'approuvee')
                ->whereMonth('created_at', Carbon::now()->month)->count();
            $data['demandes_approuvees'] = $demandesApprouvees;

            $demandesRefusees = DemandeAbsence::where('statut', 'refusee')
                ->whereMonth('created_at', Carbon::now()->month)->count();
            $data['demandes_refusees'] = $demandesRefusees;
        }
        return view('dashboard', compact('data'));
    }
}