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
        // publish package files
        $this->publishes([
            // config file
            __DIR__.'/../../config/teams.php' => config_path('teams.php'),

            // migrations
            __DIR__.'/../../database/migrations/2024_03_21_062826_create_teams_table.php' => database_path('migrations/2024_03_21_062826_create_teams_table.php'),
            __DIR__.'/../../database/migrations/2024_03_21_094513_create_member_team_table.php' => database_path('migrations/2024_03_21_094513_create_member_team_table.php'),
            __DIR__.'/../../database/migrations/2024_03_21_172901_create_resource_team_table.php' => database_path('migrations/2024_03_21_172901_create_resource_team_table.php'),
        ], static::GROUP);
    }
}