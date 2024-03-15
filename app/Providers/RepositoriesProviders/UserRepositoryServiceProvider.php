<?php

namespace App\Providers\RepositoriesProviders;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentUserRepository;
use App\Contracts\Repository\UserRepositoryContract;


class UserRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryContract::class,
            EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
