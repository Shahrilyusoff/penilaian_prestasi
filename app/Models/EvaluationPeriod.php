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
        'tarikh_mula',
        'tarikh_tamat',
        'boleh_ubah_selepas_tamat'
    ];

    protected $casts = [
        'tarikh_mula' => 'datetime',
        'tarikh_tamat' => 'datetime',
    ];

    protected $appends = ['is_active'];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function skts()
    {
        return $this->hasMany(Skt::class);
    }

    public function getIsActiveAttribute()
    {
        $today = Carbon::today();
        return $today->between($this->tarikh_mula, $this->tarikh_tamat);
    }

    // Remove the status column from database queries
    protected $hidden = ['status'];
}