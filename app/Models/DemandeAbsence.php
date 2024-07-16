<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAbsence extends Model
{
    use HasFactory;

    protected $fillable = ['employe_id', 'date_debut', 'date_fin', 'motif', 'statut'];

    public function employe()
    {
        return $this->belongsTo('Employe::class');
    }
}