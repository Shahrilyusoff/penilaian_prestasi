<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EvaluationPeriod;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer(['skt.*', 'evaluations.*'], function ($view) {
            $today = Carbon::today();

            // Active SKT periods
            $activeSktPeriods = EvaluationPeriod::where('jenis', EvaluationPeriod::JENIS_SKT)
                ->where(function ($query) use ($today) {
                    $query->where(function ($q) use ($today) {
                        $q->whereDate('tarikh_mula_awal', '<=', $today)
                        ->whereDate('tarikh_tamat_awal', '>=', $today);
                    })
                    ->orWhere(function ($q) use ($today) {
                        $q->whereDate('tarikh_mula_pertengahan', '<=', $today)
                        ->whereDate('tarikh_tamat_pertengahan', '>=', $today);
                    })
                    ->orWhere(function ($q) use ($today) {
                        $q->whereDate('tarikh_mula_akhir', '<=', $today)
                        ->whereDate('tarikh_tamat_akhir', '>=', $today);
                    });
                })
                ->get();

            // Active Penilaian periods
            $activePenilaianPeriods = EvaluationPeriod::where('jenis', EvaluationPeriod::JENIS_PENILAIAN)
                ->whereDate('tarikh_mula_penilaian', '<=', $today)
                ->whereDate('tarikh_tamat_penilaian', '>=', $today)
                ->get();

            // Merge SKT and Penilaian active periods
            $activePeriods = $activeSktPeriods->merge($activePenilaianPeriods);

            $view->with('activePeriods', $activePeriods);
        });
    }
}
