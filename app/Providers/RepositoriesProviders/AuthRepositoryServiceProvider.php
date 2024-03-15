<?php

namespace App\Providers\RepositoriesProviders;

use App\Repositories\PassportAuthRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Repository\AuthRepositoryContract;

class AuthRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryContract::class,
            PassportAuthRepository::class
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
