<?php

namespace App\Exports;

use App\Models\DemandeAbsence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AbsencesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $month;
    protected $year;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return DemandeAbsence::whereYear('date_debut', $this->year)
            ->whereMonth('date_debut', $this->month)->with('employe')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nom de l\'employé',
            'Date de début',
            'Date de fin',
            'Motif',
            'Statut',
        ];
    }

    public function map($absence): array
    {
        return [
            $absence->employe->nom . ' ' . $absence->employe->prénom,
            $absence->date_debut->format('d-m-Y'),
            $absence->date_fin->format('d-m-Y'),
            $absence->motif,
            $absence->statut,
        ];
    }
}