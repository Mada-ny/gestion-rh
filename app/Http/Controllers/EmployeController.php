<?php

namespace App\Http\Controllers;

use App\Mail\NouveauCompteEmploye;
use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:100',
            'email' => 'required|string|email|max:191|unique:employes',
            'date_naissance' => 'required|date',
            'date_embauche' => 'required|date',
            'sexe' => 'required|string|max:10',
            'nationalite' => 'required|string|max:50',
            'lieu_habitation' => 'required|string|max:100',
            'contact' => 'required|string|max:25',
            'statut' => 'required|string|max:50',
            'departement_id' => 'required|exists:departements,id',
            'role_id' => 'required|exists:roles,id',
        ]);

         // Créer l'employé
         $employe = Employe::create($request->all());

         // Générer un nom d'utilisateur unique
         $nomUtilisateur = $this->genererNomUtilisateur($employe->nom, $employe->prenom);
 
         // Générer un mot de passe temporaire
         $motDePasseTemporaire = Str::random(10);
 
         // Créer le compte utilisateur associé
         $user = User::create([
             'name' => $employe->nom . ' ' . $employe->prenom,
             'email' => $employe->email,
             'password' => Hash::make($motDePasseTemporaire),
         ]);

         // Associer l'employé au compte utilisateur
        $employe->user_id = $user->id;
        $employe->nom_utilisateur = $nomUtilisateur;
        $employe->save();

        // Envoyer un e-mail à l'employé avec ses identifiants
        $this->envoyerEmailIdentifiants($employe, $nomUtilisateur, $motDePasseTemporaire);

        return redirect()->route('employes.index')
            ->with('success', 'Employé créé avec succès. Un e-mail avec les identifiants a été envoyé.');
    }

    private function genererNomUtilisateur($nom, $prenom)
    {
        $prenom = explode(' ', $prenom);
        $baseNomUtilisateur = Str::slug(Str::lower($prenom[0] . '.' . $nom));
        $nomUtilisateur = $baseNomUtilisateur;
        $compteur = 1;

        while (Employe::where('nom_utilisateur', $nomUtilisateur)->exists()) {
            $nomUtilisateur = $baseNomUtilisateur . $compteur;
            $compteur++;
        }

        return $nomUtilisateur;
    }

    private function envoyerEmailIdentifiants($employe, $nomUtilisateur, $motDePasseTemporaire)
    {
        Mail::to($employe->email)->send(new NouveauCompteEmploye($employe, $nomUtilisateur, $motDePasseTemporaire));
    }
    
}