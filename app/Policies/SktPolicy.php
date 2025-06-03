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
        if ($user->isAdmin()) {
            return $skt->status === Skt::STATUS_DRAFT;
        }
        
        if ($user->isPYD()) {
            return $skt->pyd_id === $user->id && 
                ($skt->isAwalTahunActive() || 
                    $skt->isPertengahanTahunEditable() || 
                    ($skt->isAkhirTahunActive() && !$skt->laporan_akhir_pyd));
        }
        
        if ($user->isPPP()) {
            return $skt->ppp_id === $user->id && 
                ($skt->status === Skt::STATUS_SUBMITTED || 
                    ($skt->isAkhirTahunActive() && !$skt->ulasan_akhir_ppp));
        }
        
        return false;
    }

    public function delete(User $user, Skt $skt)
    {
        return $user->isAdmin() && $skt->status === Skt::STATUS_DRAFT;
    }

    public function approve(User $user, Skt $skt)
    {
        return $user->isPPP() && 
               $skt->ppp_id === $user->id && 
               $skt->status === Skt::STATUS_SUBMITTED;
    }

    public function updateEvaluator(User $user, Skt $skt)
    {
        return $user->isAdmin() && $skt->canAdminEditEvaluator();
    }
}