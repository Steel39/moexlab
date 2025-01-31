<?php

namespace App\Application\Trade\Queries;

use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

readonly class GetTradesByTimeQuery
{
    public function __construct(
       public TradeTimeValue $beginTimeValue,
       public TradeTimeValue $endTimeValue)
    {

    }
}
