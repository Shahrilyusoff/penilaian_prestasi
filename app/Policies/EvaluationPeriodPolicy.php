<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EvaluationPeriod;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationPeriodPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function view(User $user, EvaluationPeriod $evaluationPeriod)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User $user, EvaluationPeriod $evaluationPeriod)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function delete(User $user, EvaluationPeriod $evaluationPeriod)
    {
        return $user->isSuperAdmin();
    }
}