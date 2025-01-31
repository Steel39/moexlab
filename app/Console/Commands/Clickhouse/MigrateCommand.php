<?php

namespace App\Console\Commands\Clickhouse;

use App\Infrastructure\Repositories\Clickhouse\Migration\Rabbit\CreateTableTradesQueue;
use Illuminate\Console\Command;

class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clickhouse:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate clickhouse table';

    /**
     * Execute the console command.
     */
    public function handle(
         CreateTableTradesQueue $tradesQueue
    ): void
    {
        $tradesQueue->creatTableTradesQueue();
    }
}
