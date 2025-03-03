<?php

namespace App\Application\Market\Trade\DTOs\Market;


use function Pest\Laravel\instance;

readonly class TotalVolumeTradesDTO
{
    public function __construct(
        public readonly string $uid,
        public readonly int $totalBuyVolume,
        public readonly int $totalSellVolume,
        public readonly float $startPrice,
        public readonly float $endPrice,

    )
    {
    }

    public static function fromArray(array $trades)
    {
        return new TotalVolumeTradesDTO(
            $trades['uid'],
            $trades['total_buy'],
            $trades['total_sell'],
            $trades['start_price'],
            $trades['end_price'],
        );
    }

    public static function toArray(TotalVolumeTradesDTO $totalVolumeTradeDTO): array
    {
        return [
            'uid' => $totalVolumeTradeDTO->uid,
            'total_buy' => $totalVolumeTradeDTO->totalBuyVolume,
            'total_sell' => $totalVolumeTradeDTO->totalSellVolume,
            'start_price' => $totalVolumeTradeDTO->startPrice,
            'end_price' => $totalVolumeTradeDTO->endPrice
        ];
    }

}
