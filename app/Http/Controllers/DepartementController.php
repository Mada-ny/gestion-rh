<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:voir départements')->only(['index', 'show']);
        $this->middleware('permission:gérer départements')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departements = Departement::withCount('employes')->paginate(15);
        return view('departements.index', compact('departements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100|unique:departements,nom',
        ]);

        $departement = Departement::create($validatedData);

        return redirect()->route('departements.index')->with('success', 'Département crée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {
        $employes = $departement->employes()->paginate(15);
        return view('departements.show', compact('departement', 'employes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement)
    {
        return view('departements.modifier', compact('departement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100|unique:departements,nom,' . $departement->id,
        ]);

        $departement->update($validatedData);

        return redirect()->route('departements.show', $departement)->with('success', 'Département mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès.');
    }
}