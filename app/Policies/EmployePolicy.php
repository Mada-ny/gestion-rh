<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employe;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployePolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     * 
     * @param \App\Models\User $user
     * @param \App\Models\Employe $employe
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Employe $employe)
    {
        // Vérifier si l'utilisateur a la permission "voir employés" ou "voir ses infos"
        return $user->hasPermissionTo('voir employés') || ($user->id === $employe->user_id && $user->hasPermissionTo('voir ses infos'));
    }
}