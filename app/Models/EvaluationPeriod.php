<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EvaluationPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'jenis',
        'tarikh_mula_awal',
        'tarikh_tamat_awal',
        'tarikh_mula_pertengahan',
        'tarikh_tamat_pertengahan',
        'tarikh_mula_akhir',
        'tarikh_tamat_akhir',
        'tarikh_mula_penilaian',
        'tarikh_tamat_penilaian'
    ];

    // app/Models/EvaluationPeriod.php

    protected $casts = [
        'tarikh_mula_awal' => 'date',
        'tarikh_tamat_awal' => 'date',
        'tarikh_mula_pertengahan' => 'date',
        'tarikh_tamat_pertengahan' => 'date',
        'tarikh_mula_akhir' => 'date',
        'tarikh_tamat_akhir' => 'date',
        'tarikh_mula_penilaian' => 'date',
        'tarikh_tamat_penilaian' => 'date',
    ];

    const JENIS_SKT = 'skt';
    const JENIS_PENILAIAN = 'penilaian';

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
        } else {
            if ($today->between($this->tarikh_mula_penilaian, $this->tarikh_tamat_penilaian)) {
                return 'aktif';
            }
        }
        
        return null;
    }

    public function getIsActiveAttribute()
    {
        return $this->active_period !== null;
    }

    public function scopeSkt($query)
    {
        return $query->where('jenis', self::JENIS_SKT);
    }

    public function scopePenilaian($query)
    {
        return $query->where('jenis', self::JENIS_PENILAIAN);
    }

    public function scopeCurrentYear($query)
    {
        return $query->where('tahun', date('Y'));
    }

    public function scopeYear($query, $year)
    {
        return $query->where('tahun', $year);
    }
}