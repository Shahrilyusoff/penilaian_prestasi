<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Evaluation $evaluation)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || 
               $user->id == $evaluation->pyd_id || 
               $user->id == $evaluation->ppp_id || 
               $user->id == $evaluation->ppk_id;
    }

    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User $user, Evaluation $evaluation)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function delete(User $user, Evaluation $evaluation)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function submitPYD(User $user, Evaluation $evaluation)
    {
        return $user->id == $evaluation->pyd_id && $evaluation->status == 'draf_pyd';
    }

    public function submitPPP(User $user, Evaluation $evaluation)
    {
        return $user->id == $evaluation->ppp_id && $evaluation->status == 'draf_ppp';
    }

    public function submitPPK(User $user, Evaluation $evaluation)
    {
        return $user->id == $evaluation->ppk_id && $evaluation->status == 'draf_ppk';
    }
}