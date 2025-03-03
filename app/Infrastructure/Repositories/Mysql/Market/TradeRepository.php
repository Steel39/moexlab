<?php

namespace App\Infrastructure\Repositories\Mysql\Market;

use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

class TradeRepository implements TradeRepositoryInterface
{

    public function save(\App\Application\Market\Trade\DTOs\Market\TradeDTO $tradeDTO)
    {

    }

    public function getByTime(TradeTimeValue $timeTrade)
    {
        // TODO: Implement getByTime() method.
    }
}
