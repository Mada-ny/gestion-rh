<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:voir congés|voir ses absences')->only(['index', 'show', 'calendar']);
        $this->middleware('permission:gérer congés')->except(['index', 'show', 'calendar']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Conge::with('employe');


        if ($request->has('search') && $request->input('search') !== '') {
            $searchTerm = $request->input('search');
            $query->whereHas('employe', function ($q) use ($searchTerm) {
                $q->where('nom', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('prénom', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhere('date_debut', 'LIKE', "%{$searchTerm}%")
            ->orWhere('date_fin', 'LIKE', "%{$searchTerm}%");
        }

        $conges = $query->paginate(15);
        $allConges = $query->get();
        $mesConges = $this->getMesConges();

        Carbon::setLocale('fr');
        return view('conges.index', compact('conges', 'allConges', 'mesConges'));
    }

    public function getMesConges()
    {
        $user = auth()->user();
        return $user->employe->conges;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employes = Employe::all();
        return view('conges.create', compact('employes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $conge = Conge::create($validatedData);

        return redirect()->route('conges.index', $conge)->with('success', 'Congé crée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Conge $conge)
    {
        return view('conges.show', compact('conge'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conge $conge)
    {
        $employes = Employe::all();
        return view('conges.edit', compact('conge', 'employes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conge $conge)
    {
        $validatedData = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $conge->update($validatedData);

        return redirect()->route('conges.index', $conge)->with('success', 'Congé mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conge $conge)
    {
        $conge->delete();

        return redirect()->route('conges.index')->with('success', 'Congé supprimé avec succès.');
    }

    public function calendar()
    {
        $conges = Conge::with('employe')->get();

        $events = [];
        foreach ($conges as $conge) {
            $events[] = [
                'title' => $conge->employe->nom . ' ' . $conge->employe->prénom,
                'start' => $conge->date_debut->format('Y-m-d'),
                'end' => $conge->date_fin->addDay()->format('Y-m-d'), 
                'color' => $this->getColorFromEmployeName($conge->employe->nom),
            ];
        }

        return response()->json($events);
    }

    private function getColorFromEmployeName($employeName)
    {
        $hash = md5($employeName);
        $r = hexdec(substr($hash, 0, 2));
        $g = hexdec(substr($hash, 2, 2));
        $b = hexdec(substr($hash, 4, 2));
        return 'rgb(' . $r . ',' . $g . ',' . $b . ')';
    }
}