<?php

namespace Codelab\Teams\Providers;

use Illuminate\Support\ServiceProvider;

class TeamsServiceProvider extends ServiceProvider
{
    private const GROUP = 'codelab-teams';

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
        // publish migrations
        $this->publishesMigrations([
            __DIR__ . '/../../database/migrations' => database_path('migrations')
        ], static::GROUP);

        // publish other files
        $this->publishes([
            __DIR__.'/../../config/teams.php' => config_path('teams.php'),
        ], static::GROUP);
    }
}