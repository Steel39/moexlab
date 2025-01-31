<?php

namespace App\Console\Commands\Clickhouse;

use App\Infrastructure\Repositories\Clickhouse\Migration\Rabbit\DeleteTableTradesQueue;
use ClickHouseDB\Exception\ClickHouseException;
use Illuminate\Console\Command;

class RollbackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clickhouse:rollback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command rollback migrate';

    /**
     * Execute the console command.
     */
    public function handle(DeleteTableTradesQueue $tradesQueue)
    {$tradesQueue->down();
    }
}
