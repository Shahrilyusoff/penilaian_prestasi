<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\EvaluationPeriod;
use App\Models\User;
use App\Models\Skt;
use App\Models\Evaluation;
use App\Policies\EvaluationPeriodPolicy;
use App\Policies\UserPolicy;
use App\Policies\SktPolicy;
use App\Policies\EvaluationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        EvaluationPeriod::class => EvaluationPeriodPolicy::class,
        User::class => UserPolicy::class,
        Skt::class => SktPolicy::class,
        Evaluation::class => EvaluationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // ✅ Define the 'admin' Gate so @can('admin') works
        Gate::define('admin', function ($user) {
            return $user->peranan === 'admin' || $user->peranan === 'super_admin';
        });
    }
}
