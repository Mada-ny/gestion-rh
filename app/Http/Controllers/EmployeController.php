<?php

namespace App\Http\Controllers;

use App\Mail\NouveauCompteEmploye;
use App\Models\Employe;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Exports\EmployesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:voir ses infos')->only(['show']);
        $this->middleware('permission:voir employés')->only(['index']);
        $this->middleware('permission:gérer employés')->except(['show', 'index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employe::with('departement');

        if ($request->has('search')) {
            $query->where('prénom', 'like', '%' . $request->search . '%')
                ->orWhere('nom', 'like', '%' . $request->search . '%');
        }

        $employes = $query->paginate(15);

        return view('employes.index', compact('employes'));
    }

    public function exportEmployes()
    {
        return Excel::download(new EmployesExport, "employes_pme.xslx", \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();
        return view('employes.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prénom' => 'required|string|max:255',
            'nom' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:employes',
            'sexe' => 'required|in:masculin,féminin',
            'poste' => 'required|string|max:255',
            'departement_id' => 'required|exists:departements,id',
            'contact' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'date_embauche' => 'required|date',
            'lieu_habitation' => 'required|string|max:255',
            'nationalité' => 'required|string|max:50',
        ]);

        // Création du compte utilisateur
        $password = Str::random(10);
        $user = User::create([
            'prénom' => $validatedData['prénom'],
            'nom' => $validatedData['nom'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
        ]);

        $employe = Employe::create(array_merge($validatedData, [
            'user_id' => $user->id,
            'statut' => 'actif',
        ]));

        $user->assignRole('employe');

        // Envoi d'un email avec les informations de connexion
        $this->envoyerEmailIdentifiants($employe, $password);

        return redirect()->route('employes.index')->with('success', 'Employé créé avec succès. Un mot de passe temporaire a été envoyé à son adresse e-mail.');
    }

    private function envoyerEmailIdentifiants(Employe $employe, string $password)
    {
        $emailData = [
            'employe' => $employe,
            'password' => $password,
            'loginUrl' =>  route('login'),
        ];
        Mail::to($employe->email)->send(new NouveauCompteEmploye($emailData));
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        $this->authorize('view', $employe);
        return view('employes.show', compact('employe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employe $employe)
    {
        $departements = Departement::all();
        return view('employes.edit', compact('employe', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employe $employe)
    {
        $validatedData = $request->validate([
            'prénom' => 'required|string|max:255',
            'nom' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:employes,email,' . $employe->id,
            'sexe' => 'required|in:masculin,féminin',
            'poste' => 'required|string|max:255',
            'departement_id' => 'required|exists:departements,id',
            'contact' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'date_embauche' => 'required|date',
            'lieu_habitation' => 'required|string|max:255',
            'nationalité' => 'required|string|max:50',
            'statut' => 'required|in:actif,absent,inactif',
        ]);

        $employe->update($validatedData);

        // Mise à jour du compte utilisateur associé
        $employe->user->update([
            'prénom' => $employe->prénom,
            'nom' => $employe->nom,
            'email' => $employe->email,
        ]);

        return redirect()->route('employes.show', $employe)->with('success', 'Employé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employe)
    {
        // Mise à jour du statut de l'employé
        $employe->update([
            'statut' => 'inactif'
        ]);
        // Désactivation du compte utilisateur associé
        $employe->user->update(['email' => $employe->user->email . '_inactif']);

        return redirect()->route('employes.show', $employe)->with('success', 'Employé désactivé avec succès.');
    }
    
    public function restore(Employe $employe)
    {
        // Mise à jour du statut de l'employé
        $employe->update([
            'statut' => 'actif'
        ]);
        // Réactivation du compte utilisateur associé
        $employe->user->update(['email' => preg_replace('/_inactif$/', '', $employe->user->email)]);

        return redirect()->route('employes.show', $employe)->with('success', 'Employé réactivé avec succès.');
    }
}