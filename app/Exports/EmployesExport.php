<?php

namespace App\Exports;

use App\Models\Employe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employe::all();
    }

    public function headings(): array
    {
        return [
            'Employé',
            'Poste',
            'Email',
            'Département',
            'Sexe',
            'Statut',
            'Contact',
            'Date de naissance',
            'Date d\'embauche',
            'Lieu d\'habitation',
            'Nationalité',
        ];
    }

    public function map($employe): array
    {
        return [
            $employe->nom . ' ' . $employe->prénom,
            $employe->poste,
            $employe->email,
            $employe->departement->nom,
            $employe->sexe,
            $employe->statut,
            $employe->contact,
            $employe->date_naissance->format('d-m-Y'),
            $employe->date_embauche->format('d-m-Y'),
            $employe->lieu_habitation,
            $employe->nationalité,
        ];
    }
}