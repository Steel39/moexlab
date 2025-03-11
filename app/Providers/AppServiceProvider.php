<?php

namespace App\Providers;


use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use App\Infrastructure\Repositories\Clickhouse\Market\ClickHouseTradeRepository;
use App\Infrastructure\Repositories\Mysql\Instrument\Share\ReadShareRepository;
use App\Infrastructure\Repositories\Mysql\Instrument\Share\WriteShareRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReadShareRepositoryInterface::class, ReadShareRepository::class);
        $this->app->bind(WriteShareRepositoryInterface::class, WriteShareRepository::class);
        $this->app->bind(TradeRepositoryInterface::class, ClickHouseTradeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
