<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skt extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_period_id',
        'pyd_id',
        'ppp_id',
        'aktiviti_projek',
        'petunjuk_prestasi',
        'tambahan_pertengahan_tahun',
        'guguran_pertengahan_tahun',
        'laporan_akhir_pyd',
        'ulasan_akhir_ppp',
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
}