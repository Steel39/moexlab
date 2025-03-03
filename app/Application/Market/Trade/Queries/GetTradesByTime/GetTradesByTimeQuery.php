<?php

namespace App\Application\Market\Trade\Queries\GetTradesByTime;

use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;

readonly class GetTradesByTimeQuery
{
    public function __construct(private TradePeriodTimeDTO $periodTime)
    {

    }

    /**
     * @return TradePeriodTimeDTO
     */
    public function getPeriodTime(): TradePeriodTimeDTO
    {
        return $this->periodTime;
    }
}
