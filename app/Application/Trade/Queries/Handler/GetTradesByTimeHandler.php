<?php

namespace App\Application\Trade\Queries\Handler;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Application\Trade\Queries\GetTradesByTimeQuery;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

class GetTradesByTimeHandler
{
    public function __construct(
        private readonly TradeRepositoryInterface $tradeRepository
    )
    {
    }

    public function __invoke(GetTradesByTimeQuery $query): array
    {
        return $this->tradeRepository->getByTime($query->beginTimeValue, $query->endTimeValue);
    }
}
