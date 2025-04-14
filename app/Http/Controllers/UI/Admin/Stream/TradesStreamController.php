<?php

declare(strict_types=1);

namespace App\Http\Controllers\UI\Admin\Stream;

use App\Http\Controllers\Controller;
use App\Infrastructure\Repositories\Messaging\Trade\TradeMessagePublish;
use App\Infrastructure\Repositories\TInvestApi\Market\GetStreamTrade;

class TradesStreamController extends Controller
{
    public function __construct(
        private readonly GetStreamTrade $getStreamTrade,
        private readonly TradeMessagePublish $tradeMessagePublish
    )
    {

    }
    public function __invoke()
    {
        ($this->getStreamTrade)($this->tradeMessagePublish);
    }
}
