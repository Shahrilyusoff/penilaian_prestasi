<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Skt;
use Illuminate\Auth\Access\HandlesAuthorization;

class SktPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Skt $skt)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || 
               $user->id == $skt->pyd_id || $user->id == $skt->ppp_id;
    }

    public function create(User $user)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User $user, Skt $skt)
    {
        return $user->isSuperAdmin() || $user->isAdmin() || 
               ($user->id == $skt->pyd_id && $skt->status == 'draf') ||
               ($user->id == $skt->ppp_id && $skt->status == 'diserahkan');
    }

    public function delete(User $user, Skt $skt)
    {
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function submit(User $user, Skt $skt)
    {
        return $user->id == $skt->pyd_id && $skt->status == 'draf';
    }

    public function approve(User $user, Skt $skt)
    {
        return $user->id == $skt->ppp_id && $skt->status == 'diserahkan';
    }

    public function midYearReview(User $user, Skt $skt)
    {
        return $user->id == $skt->pyd_id;
    }

    public function finalReview(User $user, Skt $skt)
    {
        return $user->id == $skt->pyd_id || $user->id == $skt->ppp_id;
    }
}