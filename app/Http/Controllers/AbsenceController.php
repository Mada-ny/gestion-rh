<?php

namespace App\Http\Controllers;

use App\Mail\AbsenceStatusUpdatedMail;
use App\Mail\NewAbsenceRequest;
use App\Models\DemandeAbsence;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:créer absence')->only('create', 'store');
        $this->middleware('permission:voir ses absences|voir absences')->only(['index']);
        $this->middleware('permission:approuver absences')->only('updateStatus');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('employe')) {
            $absences = DemandeAbsence::where('employe_id', auth()->user()->employe->id)->latest()->paginate(15);
        } else {
            $absences = DemandeAbsence::with('employe')->latest()->paginate(15);
        }
        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('absences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:255',
        ]);

        $demande = new DemandeAbsence($validatedData);
        $demande->employe_id = Auth::user()->employe->id;
        $demande->statut = 'en_attente';
        $demande->save();

        $directeurRole = Role::where('name', 'directeur')->first();
        $directeur = $directeurRole->users()->first();

        Mail::to($directeur->email)->send(new NewAbsenceRequest($demande));

        return redirect()->route('absences.index')->with('success', 'Demande d\'absence soumise avec succès.');
    }

    public function show(DemandeAbsence $absence)
    {
        $absence->load('employe');
        return view('absences.show', compact('absence'));
    }

    public function edit(DemandeAbsence $absence)
    {
        $this->authorize('créer absence');
        
        if ($absence->statut !== 'en_attente') {
            abort(403, 'Vous ne pouvez pas modifier une demande d\'absence qui a été approuvée ou refusée.');
        }

        return view('absences.edit', compact('absence'));
    }

    public function update(Request $request, DemandeAbsence $absence)
    {
        $this->authorize('créer absence');

        $validatedData = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'required|string|max:255',
        ]);

        if ($absence->statut === 'en_attente') {
            $absence->update($validatedData);
            return redirect()->route('absences.show', $absence)->with('success', 'Demande d\'absence mise à jour avec succès.');
            } else {
                abort(403, 'Vous ne pouvez pas modifier une demande d\'absence qui a été approuvée ou refusée.');
            }
    }

    public function destroy(DemandeAbsence $absence)
    {
        $this->authorize('créer absence');

        if ($absence->statut === 'en_attente') {
            $absence->delete();
            return redirect()->route('absences.index')->with('success', 'Demande d\'absence supprimée avec succès.');
        } else {
            abort(403, 'Vous ne pouvez pas supprimer une demande d\'absence qui a été approuvée ou refusée.');
        }
    }

    public function approve(DemandeAbsence $absence)
    {
        $this->authorize('approuver absences');
        $absence->update(['statut' => 'approuvee']);

        $this->notifyEmployeeAboutStatusUpdate($absence);
        return redirect()->back()->with('success', 'Demande d\'absence approuvée.');
    }

    public function reject(DemandeAbsence $absence)
    {
        $this->authorize('approuver absences');
        $absence->update(['statut' => 'refusee']);
        $absence->employe->statut = 'actif';
        $absence->employe->save();

        $this->notifyEmployeeAboutStatusUpdate($absence);
        return redirect()->back()->with('success', 'Demande d\'absence refusée.');
    }
    
    protected function notifyEmployeeAboutStatusUpdate(DemandeAbsence $absence)
    {
        $employe = $absence->employe;
        $emailData = [
            'nom' => $employe->nom,
            'prenom' => $employe->prenom,
            'date_debut' => $absence->date_debut->format('d/m/Y'),
            'date_fin' => $absence->date_fin->format('d/m/Y'),
            'statut' => $absence->statut,
    ];

    Mail::to($employe->email)
        ->send(new AbsenceStatusUpdatedMail($emailData));
    }
}