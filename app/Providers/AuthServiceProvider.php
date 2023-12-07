<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::class => \App\Policies\QueueMonitorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Passport::tokensExpireIn(now()->addYears(5));
        //Passport::refreshTokensExpireIn(now()->addYears(5));
    }
}
