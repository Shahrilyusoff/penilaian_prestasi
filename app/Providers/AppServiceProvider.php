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
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('currentUser', auth()->user());
            }
        });

        View::composer(['skt.*', 'evaluations.*'], function ($view) {
            $view->with('activePeriods', EvaluationPeriod::whereDate('tarikh_mula', '<=', Carbon::today())
                ->whereDate('tarikh_tamat', '>=', Carbon::today())
                ->get());
        });
    }
}