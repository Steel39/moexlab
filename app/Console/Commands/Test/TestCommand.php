<?php

namespace App\Console\Commands\Test;

use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Infrastructure\Repositories\Clickhouse\Market\ClickHouseTradeRepository;
use Google\Protobuf\Timestamp;
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
    public function handle(ClickHouseTradeRepository $repository)
    {
        $time = new \DateTime('2025-01-27 16:35:01');
        $data = $repository->getByTime($time->getTimestamp());
        dd($data);
    }
}
