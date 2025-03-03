<?php

namespace App\Console\Commands\Test;

use App\Infrastructure\Repositories\Clickhouse\Instrument\ClickhouseInstrumentRepository;
use App\Infrastructure\Repositories\TInvestApi\Instrument\Shares\TInvestSharesRepository;
use Illuminate\Console\Command;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(TInvestSharesRepository $investSharesRepository, ClickhouseInstrumentRepository $repository)
    {
        $data = $investSharesRepository->getShares();
        $repository->saveAll('shares', $data);
    }
}
