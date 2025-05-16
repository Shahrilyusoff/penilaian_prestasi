<?php

namespace App\Rules;

use App\Models\EvaluationPeriod;
use Illuminate\Contracts\Validation\Rule;

class ActiveEvaluationPeriod implements Rule
{
    public function passes($attribute, $value)
    {
        $period = EvaluationPeriod::find($value);
        return $period && $period->status;
    }

    public function message()
    {
        return 'Tempoh penilaian yang dipilih tidak aktif.';
    }
}