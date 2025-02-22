<?php

namespace App\Providers;


use App\Domain\Instrument\Share\Repository\ReadShareRepositoryInterface;
use App\Domain\Instrument\Share\Repository\WriteShareRepositoryInterface;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Infrastructure\Repositories\Clickhouse\Instrument\ClickhouseInstrumentRepository;
use App\Infrastructure\Repositories\Clickhouse\Market\ClickHouseTradeRepository;
use App\Infrastructure\Repositories\Mysql\Instrument\LocalSharesRepository;
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
