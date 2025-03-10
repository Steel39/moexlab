<?php

namespace App\Providers;


use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Repositories\Share\Repository\ReadShareRepositoryInterface;
use App\Domain\Repositories\Share\Repository\WriteShareRepositoryInterface;
use App\Infrastructure\Repositories\Clickhouse\Instrument\ClickhouseInstrumentRepository;
use App\Infrastructure\Repositories\Clickhouse\Market\ClickHouseTradeRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReadShareRepositoryInterface::class, ClickhouseInstrumentRepository::class);
        $this->app->bind(WriteShareRepositoryInterface::class, ClickhouseInstrumentRepository::class);
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
