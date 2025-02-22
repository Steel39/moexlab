<?php

namespace App\Domain\Market\Trade;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Application\Trade\DTOs\TradePeriodTimeDTO;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;

interface TradeRepositoryInterface
{
    public function save(TradeDTO $tradeDTO);
    public function getByTime(TradePeriodTimeDTO $periodTime);

    public function getByUid(string $uid);
}
