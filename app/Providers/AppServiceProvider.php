<?php

namespace App\Providers;

use App\Repositories\Contracts\PlayerNoteRepositoryInterface;
use App\Repositories\Contracts\PlayerRepositoryInterface;
use App\Repositories\Eloquent\PlayerNoteRepository;
use App\Repositories\Eloquent\PlayerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlayerNoteRepositoryInterface::class,
            PlayerNoteRepository::class,
        );

        $this->app->bind(
            PlayerRepositoryInterface::class,
            PlayerRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
