<?php

namespace App\Providers;

use App\Repositories\Classes\RequestsEloquentRepository;
use App\Repositories\Classes\UserEloquentRepository;
use App\Repositories\Contracts\RequestsEloquentRepositoryInterface;
use App\Repositories\Contracts\UserEloquentRepositoryInterface;
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
        $this->registerRepositories();
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

    public function registerRepositories()
    {
        $this->app->bind(
            RequestsEloquentRepositoryInterface::class,
            RequestsEloquentRepository::class
        );

        $this->app->bind(
            UserEloquentRepositoryInterface::class,
            UserEloquentRepository::class
        );
    }
}
