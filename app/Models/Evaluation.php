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

    // Status constants
    const STATUS_DRAFT_PYD = 'draf_pyd';
    const STATUS_DRAFT_PPP = 'draf_ppp';
    const STATUS_DRAFT_PPK = 'draf_ppk';
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

    public function calculateSectionScores()
    {
        $scores = [
            'ppp' => [
                'III' => 0,
                'IV' => 0,
                'V' => 0,
                'VI' => 0,
                'total' => 0
            ],
            'ppk' => [
                'III' => 0,
                'IV' => 0,
                'V' => 0,
                'VI' => 0,
                'total' => 0
            ],
            'average' => 0
        ];

        $criteriaCount = [
            'III' => 0,
            'IV' => 0,
            'V' => 0,
            'VI' => 1 // Only one criteria in Bahagian VI
        ];

        foreach ($this->scores as $score) {
            $bahagian = $score->criteria->bahagian;
            
            // Count criteria per section
            if (in_array($bahagian, ['III', 'IV', 'V'])) {
                $criteriaCount[$bahagian]++;
            }

            // Calculate PPP scores
            if ($score->markah_ppp !== null) {
                $scores['ppp'][$bahagian] += $score->markah_ppp;
            }

            // Calculate PPK scores
            if ($score->markah_ppk !== null) {
                $scores['ppk'][$bahagian] += $score->markah_ppk;
            }
        }

        // Calculate weighted scores
        foreach (['ppp', 'ppk'] as $evaluator) {
            // Bahagian III (50%)
            if ($criteriaCount['III'] > 0) {
                $scores[$evaluator]['III'] = ($scores[$evaluator]['III'] / ($criteriaCount['III'] * 10)) * 50;
            }

            // Bahagian IV (25%)
            if ($criteriaCount['IV'] > 0) {
                $scores[$evaluator]['IV'] = ($scores[$evaluator]['IV'] / ($criteriaCount['IV'] * 10)) * 25;
            }

            // Bahagian V (20%)
            if ($criteriaCount['V'] > 0) {
                $scores[$evaluator]['V'] = ($scores[$evaluator]['V'] / ($criteriaCount['V'] * 10)) * 20;
            }

            // Bahagian VI (5%)
            $scores[$evaluator]['VI'] = ($scores[$evaluator]['VI'] / 10) * 5;

            // Total
            $scores[$evaluator]['total'] = array_sum([
                $scores[$evaluator]['III'],
                $scores[$evaluator]['IV'],
                $scores[$evaluator]['V'],
                $scores[$evaluator]['VI']
            ]);
        }

        // Calculate average
        $scores['average'] = ($scores['ppp']['total'] + $scores['ppk']['total']) / 2;

        return $scores;
    }

    public function canEditBahagian($bahagian, $user)
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return $this->status === self::STATUS_COMPLETED;
        }

        switch ($bahagian) {
            case 'II':
                return $user->isPYD() && $this->pyd_id === $user->id && $this->status === self::STATUS_DRAFT_PYD;
            case 'III':
            case 'IV':
            case 'V':
            case 'VI':
            case 'VIII':
                if ($user->isPPP() && $this->ppp_id === $user->id) {
                    return $this->status === self::STATUS_DRAFT_PPP;
                }
                if ($user->isPPK() && $this->ppk_id === $user->id) {
                    return $this->status === self::STATUS_DRAFT_PPK;
                }
                return false;
            case 'VII':
            case 'IX':
                return false; // These are calculated/display only
            default:
                return false;
        }
    }

    public function canSubmit($user)
    {
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return false;
        }

        if ($user->isPYD() && $this->pyd_id === $user->id) {
            return $this->status === self::STATUS_DRAFT_PYD && 
                   $this->kegiatan_sumbangan !== null && 
                   $this->latihan_dihadiri !== null && 
                   $this->latihan_diperlukan !== null;
        }

        if ($user->isPPP() && $this->ppp_id === $user->id) {
            if ($this->status !== self::STATUS_DRAFT_PPP) {
                return false;
            }

            foreach ($this->scores as $score) {
                if ($score->markah_ppp === null) {
                    return false;
                }
            }

            return $this->tempoh_penilaian_ppp_mula !== null && 
                   $this->tempoh_penilaian_ppp_tamat !== null && 
                   $this->ulasan_keseluruhan_ppp !== null && 
                   $this->kemajuan_kerjaya_ppp !== null;
        }

        if ($user->isPPK() && $this->ppk_id === $user->id) {
            if ($this->status !== self::STATUS_DRAFT_PPK) {
                return false;
            }

            foreach ($this->scores as $score) {
                if ($score->markah_ppk === null) {
                    return false;
                }
            }

            return $this->tempoh_penilaian_ppk_mula !== null && 
                   $this->tempoh_penilaian_ppk_tamat !== null && 
                   $this->ulasan_keseluruhan_ppk !== null;
        }

        return false;
    }

    public function getNextStatus()
    {
        switch ($this->status) {
            case self::STATUS_DRAFT_PYD:
                return self::STATUS_DRAFT_PPP;
            case self::STATUS_DRAFT_PPP:
                return self::STATUS_DRAFT_PPK;
            case self::STATUS_DRAFT_PPK:
                return self::STATUS_COMPLETED;
            default:
                return $this->status;
        }
    }
}