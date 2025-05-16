<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_period_id',
        'pyd_id',
        'ppp_id',
        'ppk_id',
        'kegiatan_sumbangan',
        'latihan_dihadiri',
        'latihan_diperlukan',
        'tempoh_penilaian_ppp_mula',
        'tempoh_penilaian_ppp_tamat',
        'ulasan_keseluruhan_ppp',
        'kemajuan_kerjaya_ppp',
        'tempoh_penilaian_ppk_mula',
        'tempoh_penilaian_ppk_tamat',
        'ulasan_keseluruhan_ppk',
        'status'
    ];

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

    public function ppk()
    {
        return $this->belongsTo(User::class, 'ppk_id');
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class);
    }

    public function skt()
    {
        return $this->hasOne(Skt::class, 'evaluation_period_id', 'evaluation_period_id')
            ->where('pyd_id', $this->pyd_id);
    }

    public function calculateTotalScore()
    {
        $totalPPP = 0;
        $totalPPK = 0;

        foreach ($this->scores as $score) {
            $totalPPP += $score->markah_ppp * $score->criteria->wajaran / 100;
            $totalPPK += $score->markah_ppk * $score->criteria->wajaran / 100;
        }

        return [
            'ppp' => $totalPPP,
            'ppk' => $totalPPK,
            'purata' => ($totalPPP + $totalPPK) / 2
        ];
    }

    public function calculateSectionScore($section, $group = null)
    {
        $query = $this->scores()->whereHas('criteria', function($q) use ($section, $group) {
            $q->where('bahagian', $section);
            if ($group) {
                $q->where('kumpulan_pyd', $group);
            }
        });

        $totalPPP = $query->sum('markah_ppp') * $this->scores->first()->criteria->wajaran / 100;
        $totalPPK = $query->sum('markah_ppk') * $this->scores->first()->criteria->wajaran / 100;
        $totalWeight = $query->count() * $this->scores->first()->criteria->wajaran;

        return [
            'ppp' => $totalPPP ? round($totalPPP / $query->count(), 2) : 0,
            'ppk' => $totalPPK ? round($totalPPK / $query->count(), 2) : 0,
            'total' => $totalWeight
        ];
    }
}