<?php

namespace App\Providers;

use App\Domain\Instrument\Share\ShareRepositoryInterface;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Infrastructure\Repositories\Mysql\Instrument\LocalSharesRepository;
use App\Infrastructure\Repositories\Redis\Market\Trade\TradeCacheRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ShareRepositoryInterface::class, LocalSharesRepository::class);
        $this->app->bind(TradeRepositoryInterface::class, TradeCacheRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
