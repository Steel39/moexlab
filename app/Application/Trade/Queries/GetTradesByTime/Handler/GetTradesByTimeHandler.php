<?php

namespace App\Application\Trade\Queries\GetTradesByTime\Handler;

use App\Application\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Domain\Market\Trade\TradeRepositoryInterface;

readonly class GetTradesByTimeHandler
{
    public function __construct(private TradeRepositoryInterface $tradeRepository)
    {
    }

    public function handle(GetTradesByTimeQuery $query)
    {
        return $this->tradeRepository->getByTime($query->getPeriodTime());
    }
}
