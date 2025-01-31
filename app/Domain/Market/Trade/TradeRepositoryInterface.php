<?php

namespace App\Domain\Market\Trade;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

interface TradeRepositoryInterface
{
    public function save(TradeDTO $tradeDTO);
    public function getByTime(TradeTimeValue $beginTime, TradeTimeValue $endTime);
}
