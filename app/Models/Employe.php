<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prénom',
        'nom',
        'email',
        'sexe',
        'poste',
        'departement_id',
        'contact',
        'date_naissance',
        'date_embauche',
        'statut',
        'lieu_habitation',
        'nationalité',
        'user_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_embauche' => 'date',
        'sexe' => 'string',
        'statut' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function demandesAbsence()
    {
        return $this->hasMany(DemandeAbsence::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_naissance->age;
    }
}