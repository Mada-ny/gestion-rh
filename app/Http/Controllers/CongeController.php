<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('employe')->paginate(15);
        return view('conges.index', compact('conges'));
    }

    public function create()
    {
        $employes = Employe::all();
        return view('conges.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Conge::create($request->all());

        return redirect()->route('conges.index')->with('success', 'Congé créé avec succès.');
    }

    public function show(Conge $conge)
    {
        return view('conges.show', compact('conge'));
    }

    public function edit(Conge $conge)
    {
        $employes = Employe::all();
        return view('conges.edit', compact('conge', 'employes'));
    }

    public function update(Request $request, Conge $conge)
    {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $conge->update($request->all());

        return redirect()->route('conges.index')->with('success', 'Congé mis à jour avec succès.');
    }

    public function destroy(Conge $conge)
    {
        $conge->delete();

        return redirect()->route('conges.index')->with('success', 'Congé supprimé avec succès.');
    }
}