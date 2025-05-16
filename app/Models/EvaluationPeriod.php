<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'tarikh_mula',
        'tarikh_tamat',
        'status',
        'boleh_ubah_selepas_tamat'
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function skts()
    {
        return $this->hasMany(Skt::class);
    }
}