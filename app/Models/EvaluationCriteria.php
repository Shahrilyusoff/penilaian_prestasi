<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    protected $table = 'evaluation_criteria';
    use HasFactory;

    protected $fillable = [
        'bahagian',
        'kriteria',
        'wajaran',
        'kumpulan_pyd'
    ];

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class, 'criteria_id');
    }
}