<?php

namespace App\Infrastructure\Repositories\Redis\Market\Trade;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use Illuminate\Support\Facades\Redis;

class TradeCacheRepository implements TradeRepositoryInterface
{
    public function __construct(private readonly Redis $redis)
    {
    }

    public function save(TradeDTO $tradeDTO)
    {
        $this->redis::hmset($tradeDTO->time->getMicrotime(),
            [
                'uid' => $tradeDTO->instrument_uid->getUid(),
                'direction' => $tradeDTO->direction->toInt(),
                'price' => $tradeDTO->price->getFloatPrice(),
                'quantity' => $tradeDTO->quantity->getQuantity(),
                'time' => $tradeDTO->time->toString(),
            ]);

        print_r( $this->redis::hgetall("time:{$tradeDTO->time->getMicroTime()}"));
    }

    public function getByTime(TradeTimeValue $timeTrade)
    {
        // TODO: Implement getByTime() method.
    }
}
