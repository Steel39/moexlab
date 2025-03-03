<?php

namespace App\Domain\Market\Trade;

use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;

interface TradeRepositoryInterface
{
    public function save(TradeDTO $tradeDTO);

    public function getByTime(TradePeriodTimeDTO $periodTime);

    public function getByUid(string $uid);

    public function getSumTrades(TradePeriodTimeDTO $periodTime);
}
