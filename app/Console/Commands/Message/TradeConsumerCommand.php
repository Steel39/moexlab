<?php

namespace App\Console\Commands\Message;

use App\Infrastructure\Adapters\RabbitMQAdapter;
use App\Infrastructure\Repositories\Messaging\Trade\TradeMessageConsumer;
use Illuminate\Console\Command;

class TradeConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        TradeMessageConsumer $consumer
    )
    {
        $consumer->consume();
    }
}
