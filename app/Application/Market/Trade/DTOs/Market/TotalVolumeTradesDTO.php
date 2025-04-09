<?php

namespace App\Application\Market\Trade\DTOs\Market;


use function Pest\Laravel\instance;

readonly class TotalVolumeTradesDTO
{
    public function __construct(
        public  string $uid,
        public  int $totalBuyVolume,
        public  int $totalSellVolume,
        public  float $firstPrice,
        public  string $firstTime,
        public  float $lastPrice,
        public  string $lastTime,
        public ?float $avgBuy,
        public ?float $avgSell,

    )
    {
    }
    public static function fromArray(array $trades): self
    {
        return new TotalVolumeTradesDTO(
            $trades["uid"],
            $trades["total_buy_quantity"],
            $trades["total_sell_quantity"],
            $trades["first_trade_price"],
            $trades["first_trade_time"],
            $trades["last_trade_price"],
            $trades["last_trade_time"],
            $trades['avg_buy_price'],
            $trades['avg_sell_price'],
        );
    }

    public static function toArray(TotalVolumeTradesDTO $totalVolumeTradeDTO): array
    {
        return [
            "uid" => $totalVolumeTradeDTO->uid,
            "total_buy_quantity" => $totalVolumeTradeDTO->totalBuyVolume,
            "total_sell_quantity" => $totalVolumeTradeDTO->totalSellVolume,
            "first_trade_price" => $totalVolumeTradeDTO->firstPrice,
            "first_trade_time" => $totalVolumeTradeDTO->firstTime,
            "last_trade_price" => $totalVolumeTradeDTO->lastPrice,
            "last_trade_time" => $totalVolumeTradeDTO->lastTime,
           "avg_buy_price" => $totalVolumeTradeDTO->avgBuy,
           "avg_sell_price" => $totalVolumeTradeDTO->avgSell
        ];
    }

}
