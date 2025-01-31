<?php

namespace App\Domain\Market\Trade;

use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;

class Trade
{
    public function __construct(
        private readonly TradeUidValue $uid,
        private readonly TradeDirectionValue $direction,
        private readonly TradePriceValue $price,
        private readonly TradeQuantityValue $quantity,
        private readonly TradeTimeValue $time,
    )
    {
    }
}
