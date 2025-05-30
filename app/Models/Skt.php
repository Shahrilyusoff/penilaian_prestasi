<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skt extends Model
{
    use HasFactory;
    protected $table ='skt';

    protected $fillable = [
        'evaluation_period_id',
        'pyd_id',
        'ppp_id',
        'aktiviti_projek',
        'petunjuk_prestasi',
        'laporan_akhir_pyd',
        'ulasan_akhir_ppp',
        'status'
    ];

    const STATUS_DRAFT = 'draf';
    const STATUS_SUBMITTED = 'diserahkan';
    const STATUS_APPROVED = 'disahkan';
    const STATUS_COMPLETED = 'selesai';

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

    public function canEdit()
    {
        return $this->status === self::STATUS_DRAFT || 
               ($this->status === self::STATUS_SUBMITTED && auth()->id() === $this->ppp_id);
    }

    public function canDelete()
    {
        return $this->status === self::STATUS_DRAFT && auth()->user()->isAdmin();
    }

    public function isAwalTahunActive()
    {
        return $this->evaluationPeriod->active_period === 'awal';
    }

    public function isPertengahanTahunActive()
    {
        return $this->evaluationPeriod->active_period === 'pertengahan';
    }

    public function isAkhirTahunActive()
    {
        return $this->evaluationPeriod->active_period === 'akhir';
    }

    public function getActivePeriodAttribute()
    {
        $today = Carbon::today();
        
        if ($this->jenis === self::JENIS_SKT) {
            if ($today->between($this->tarikh_mula_awal, $this->tarikh_tamat_awal)) {
                return 'awal';
            } elseif ($today->between($this->tarikh_mula_pertengahan, $this->tarikh_tamat_pertengahan)) {
                return 'pertengahan';
            } elseif ($today->between($this->tarikh_mula_akhir, $this->tarikh_tamat_akhir)) {
                return 'akhir';
            }
        }
        
        return null;
    }

    public function getIsActiveAttribute()
    {
        return $this->active_period !== null;
    }

    public function scopeActiveAwalTahun($query)
    {
        return $query->whereDate('tarikh_mula_awal', '<=', now())
            ->whereDate('tarikh_tamat_awal', '>=', now());
    }

    public function scopeActivePertengahanTahun($query)
    {
        return $query->whereDate('tarikh_mula_pertengahan', '<=', now())
            ->whereDate('tarikh_tamat_pertengahan', '>=', now());
    }

    public function scopeActiveAkhirTahun($query)
    {
        return $query->whereDate('tarikh_mula_akhir', '<=', now())
            ->whereDate('tarikh_tamat_akhir', '>=', now());
    }
}