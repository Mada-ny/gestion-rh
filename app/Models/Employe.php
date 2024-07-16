<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nom','prenom','email','mot_de_passe','nom_utilisateur','date_naisssance','date_embauche','sexe','nationalite','lieu_habitation','contact','statut','departement_id','role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function conge()
    {
        return $this->hasOne(Conge::class);
    }

    public function demandeAbsences()
    {
        return $this->hasMany(DemandeAbsence::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}