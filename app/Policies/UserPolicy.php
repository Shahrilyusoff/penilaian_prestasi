<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function view(User $user, User $model)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User $user, User $model)
    {
        return $user->isSuperAdmin() || ($user->isAdmin() && !$model->isSuperAdmin());
    }

    public function delete(User $user, User $model)
    {
        return $user->isSuperAdmin() || ($user->isAdmin() && !$model->isSuperAdmin());
    }

    public function assignEvaluators(User $user, User $model)
    {
        return ($user->isSuperAdmin() || $user->isAdmin()) && $model->isPYD();
    }
}