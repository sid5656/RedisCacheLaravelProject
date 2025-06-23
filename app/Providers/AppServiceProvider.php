<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Observers\ProjectObserver;
use Laravel\Sanctum\Sanctum;
use App\Models\Sanctum\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** Project Observer to track changes  in project table*/
        Project::observe(ProjectObserver::class);

        /** Access Token  */
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }
}
