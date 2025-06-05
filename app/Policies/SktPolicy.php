<?php

namespace App\Policies;

use App\Models\Skt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SktPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Skt $skt)
    {
        return $user->isAdmin() || 
               $user->id === $skt->pyd_id || 
               $user->id === $skt->ppp_id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Skt $skt)
    {
        return $user->isAdmin() && $skt->status === Skt::STATUS_DRAFT;
    }

    public function delete(User $user, Skt $skt)
    {
        return $user->isAdmin() && $skt->status === Skt::STATUS_DRAFT;
    }

    public function submitAwal(User $user, Skt $skt)
    {
        return $user->id === $skt->pyd_id && 
               $skt->status === Skt::STATUS_DRAFT &&
               $skt->current_phase === 'awal';
    }

    public function approveAwal(User $user, Skt $skt)
    {
        return $user->id === $skt->ppp_id && 
               $skt->status === Skt::STATUS_SUBMITTED_AWAL &&
               $skt->current_phase === 'awal';
    }

    public function submitPertengahan(User $user, Skt $skt)
    {
        return $user->id === $skt->pyd_id && 
               $skt->status === Skt::STATUS_APPROVED_AWAL &&
               $skt->current_phase === 'pertengahan';
    }

    public function approvePertengahan(User $user, Skt $skt)
    {
        return $user->id === $skt->ppp_id && 
               $skt->status === Skt::STATUS_SUBMITTED_PERTENGAHAN &&
               $skt->current_phase === 'pertengahan';
    }

    public function submitAkhir(User $user, Skt $skt)
    {
        return ($user->id === $skt->pyd_id || $user->id === $skt->ppp_id) && 
               $skt->status === Skt::STATUS_APPROVED_PERTENGAHAN &&
               $skt->current_phase === 'akhir';
    }

    public function reopen(User $user, Skt $skt)
    {
        return $user->isAdmin() && 
               in_array($skt->current_phase, ['awal', 'pertengahan', 'akhir']) &&
               !in_array($skt->status, [Skt::STATUS_DRAFT, Skt::STATUS_COMPLETED]);
    }
}