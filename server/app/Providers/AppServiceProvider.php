<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\IEmployeeService', 'App\Services\EmployeeService');
        $this->app->bind('App\Interfaces\IFileService', 'App\Services\FileService');
        $this->app->bind('App\Interfaces\IMatcherService', 'App\Services\MatcherService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
