<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Skt extends Model
{
    use HasFactory;

    protected $table = 'skt';

    protected $fillable = [
        'evaluation_period_id',
        'pyd_id',
        'ppp_id',
        'skt_awal',
        'skt_awal_approved_at',
        'skt_pertengahan',
        'skt_pertengahan_approved_at',
        'skt_akhir_pyd',   // string report, no casting here
        'skt_akhir_ppp',   // string report, no casting here
        'status'
    ];

    protected $casts = [
        'skt_awal' => 'array',
        'skt_pertengahan' => 'array',
        'skt_awal_approved_at' => 'datetime',
        'skt_pertengahan_approved_at' => 'datetime',
        // removed skt_akhir_pyd and skt_akhir_ppp casts
    ];

    const STATUS_DRAFT = 'draf';
    const STATUS_SUBMITTED_AWAL = 'diserahkan_awal';
    const STATUS_APPROVED_AWAL = 'disahkan_awal';
    const STATUS_SUBMITTED_PERTENGAHAN = 'diserahkan_pertengahan';
    const STATUS_APPROVED_PERTENGAHAN = 'disahkan_pertengahan';
    const STATUS_COMPLETED = 'selesai';
    const STATUS_NOT_SUBMITTED = 'tidak_diserahkan';

    public function evaluationPeriod()
    {
        return $this->belongsTo(EvaluationPeriod::class);
    }

    public function pyd()
    {
        return $this->belongsTo(User::class, 'pyd_id');
    }

    public function ppp()
    {
        return $this->belongsTo(User::class, 'ppp_id');
    }

    public function getCurrentPhaseAttribute()
    {
        $period = $this->evaluationPeriod;
        $today = Carbon::today();

        if ($today->between($period->tarikh_mula_awal, $period->tarikh_tamat_awal)) {
            return 'awal';
        } elseif ($today->between($period->tarikh_mula_pertengahan, $period->tarikh_tamat_pertengahan)) {
            return 'pertengahan';
        } elseif ($today->between($period->tarikh_mula_akhir, $period->tarikh_tamat_akhir)) {
            return 'akhir';
        }

        return null;
    }

    public function canEditPertengahan()
    {
        return $this->status === self::STATUS_APPROVED_AWAL && 
            $this->current_phase === 'pertengahan' &&
            auth()->user()->id === $this->pyd_id;
    }

    public function canApprovePertengahan()
    {
        return $this->status === self::STATUS_SUBMITTED_PERTENGAHAN && 
            $this->current_phase === 'pertengahan' &&
            auth()->user()->id === $this->ppp_id;
    }

    public function canPYDEdit()
    {
        if ($this->status === self::STATUS_DRAFT && $this->current_phase === 'awal') {
            return true;
        }

        if ($this->status === self::STATUS_APPROVED_AWAL && $this->current_phase === 'pertengahan') {
            return true;
        }

        if ($this->status === self::STATUS_APPROVED_PERTENGAHAN && $this->current_phase === 'akhir') {
            return true;
        }

        return false;
    }

    public function canPPPApprove()
    {
        return ($this->status === self::STATUS_SUBMITTED_AWAL && $this->current_phase === 'awal') ||
               ($this->status === self::STATUS_SUBMITTED_PERTENGAHAN && $this->current_phase === 'pertengahan');
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
