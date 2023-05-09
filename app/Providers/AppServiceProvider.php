<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //
        // Disable Laravel's default migrations
        // \Illuminate\Database\Eloquent\Model::preventUsingGuarded([]);
        // Disable migrations for the default Laravel tables
        // Schema::disableForeignKeyConstraints();
        // $this->app->bind('path.public', function() {
        //     return base_path().'/public_html';
        // });
    }
}
