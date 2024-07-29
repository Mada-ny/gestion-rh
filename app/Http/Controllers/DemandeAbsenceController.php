<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeAbsence;
use App\Notifications\DemandeAbsenceStatusChanged;

class DemandeAbsenceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->employe->role->nom;

        if ($role === 'directeur') {
            $demandes = DemandeAbsence::with('employe')->orderBy('date_debut', 'desc')->paginate(15);
        } elseif ($role === 'employe') {
            $demandes = DemandeAbsence::where('employe_id', $user->employe->id)
                                      ->orderBy('date_debut', 'desc')
                                      ->paginate(15);
        } else {
            abort(403, 'Accès non autorisé.');
        }

        return view('demande_absences.index', compact('demandes', 'role'));
    }
    public function create()
    {
        return view('demande_absences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:255',
        ]);

        $demandeAbsence = new DemandeAbsence($request->all());
        $demandeAbsence->employe_id = auth()->user()->employe->id;
        $demandeAbsence->statut = 'en_attente';
        $demandeAbsence->save();

        return redirect()->route('dashboard')
            ->with('success', 'Votre demande d\'absence a été soumise avec succès.');
    }

    public function approve(DemandeAbsence $demandeAbsence)
    {
        $demandeAbsence->statut = 'approuvee';
        $demandeAbsence->save();

        $this->notifyEmployee($demandeAbsence);

        return redirect()->back()->with('success', 'Demande d\'absence approuvée.');
    }

    public function reject(DemandeAbsence $demandeAbsence)
    {
        $demandeAbsence->statut = 'refusee';
        $demandeAbsence->save();

        $this->notifyEmployee($demandeAbsence);

        return redirect()->back()->with('success', 'Demande d\'absence refusée.');
    }

    private function notifyEmployee(DemandeAbsence $demandeAbsence)
    {
        $employe = $demandeAbsence->employe;
        $employe->user->notify(new DemandeAbsenceStatusChanged($demandeAbsence));
    }

}