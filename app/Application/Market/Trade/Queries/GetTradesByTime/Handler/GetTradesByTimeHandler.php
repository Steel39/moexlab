<?php

namespace App\Application\Market\Trade\Queries\GetTradesByTime\Handler;

use App\Application\Market\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Domain\Market\Trade\TradeRepositoryInterface;

readonly class GetTradesByTimeHandler
{
    public function __construct(private TradeRepositoryInterface $tradeRepository)
    {
    }

    public function __invoke(GetTradesByTimeQuery $query)
    {
        return $this->tradeRepository->getSumTrades($query->getPeriodTime());
    }
}
