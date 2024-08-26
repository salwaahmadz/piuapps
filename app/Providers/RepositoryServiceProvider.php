<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\PesertaRepository;
use App\Repositories\PengajarRepository;
use App\Repositories\KeuanganRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\PesertaRepositoryInterface;
use App\Repositories\Interfaces\PengajarRepositoryInterface;
use App\Repositories\Interfaces\KeuanganRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PesertaRepositoryInterface::class, PesertaRepository::class);
        $this->app->bind(PengajarRepositoryInterface::class, PengajarRepository::class);
        $this->app->bind(KeuanganRepositoryInterface::class, KeuanganRepository::class);
    }
}
