<?php

namespace App\Application\Market\Trade\DTOs;

use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

class TradePeriodTimeDTO
{
    public function __construct(
        public TradeTimeValue $beginTimeValue,
        public TradeTimeValue $endTimeValue)
    {

    }
}
