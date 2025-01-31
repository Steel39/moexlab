<?php

namespace App\Application\Trade\DTOs\Market;

use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;

final readonly class TradeDTO
{
    public function __construct(
        public TradeUidValue       $instrument_uid,
        public TradeDirectionValue $direction,
        public TradePriceValue     $price,
        public TradeQuantityValue  $quantity,
        public TradeTimeValue      $time,
    )
    {
    }
}
