<?php

namespace App\Providers;
use App\Models\Opportunity;
use App\Policies\OpportunityPolicy;
use App\Models\Activity;
use App\Policies\ActivityPolicy;
use App\Models\Installation;
use App\Policies\InstallationPolicy;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    Opportunity::class => OpportunityPolicy::class,
    Activity::class => ActivityPolicy::class,
    Installation::class => InstallationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
