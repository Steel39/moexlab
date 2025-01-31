<?php

namespace App\Console\Commands\TInvestApi\Market;

use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Infrastructure\Repositories\Messaging\Trade\TradeMessagePublish;
use App\Infrastructure\Repositories\TInvestApi\Market\GetStreamTrade;
use Illuminate\Console\Command;

class GetStreamTradesCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stream:trades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get stream trades of Shares from t-invest-api';

    /**
     * Execute the console command.
     */
    public function handle(GetStreamTrade $getStreamTrade, TradeMessagePublish $messagePublish)
    {
         $getStreamTrade($messagePublish);
    }
}
