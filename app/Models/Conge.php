<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
    
    public function getDureeAttribute()
    {
        return $this->date_debut->diffInDays($this->date_fin) + 1;
    }

    public function getMoisDebutAttribute()
    {
        return $this->date_debut->month;
    }
}