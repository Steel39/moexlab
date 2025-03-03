<?php

namespace App\Application\Market\Trade\DTOs\Market;

use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;

final readonly class TradeDTO
{
    public function __construct(
        public TradeUidValue       $instrument_uid,
        public TradeDirectionValue $direction,
        public TradePriceValue     $price,
        public TradeQuantityValue  $quantity,
        public TradeTimeValue      $time,
    )
    {
    }

    public static function toArray(TradeDTO $tradeDTO): array
    {
        $array_data = [
            'instrument_uid' => $tradeDTO->instrument_uid->getUid(),
            'direction' => $tradeDTO->direction->toInt(),
            'price' => $tradeDTO->price->getFloatPrice(),
            'quantity' => $tradeDTO->quantity->getQuantity(),
            'time' => $tradeDTO->time->getSeconds(),
        ];
        return $array_data;
    }

    public static function fromArray(array $array): TradeDTO
    {
        return new TradeDTO(
            new TradeUidValue($array['instrument_uid']),
            new TradeDirectionValue($array['direction']),
            new TradePriceValue($array['price']),
            new TradeQuantityValue($array['quantity']),
            new TradeTimeValue($array['time']),
        );
    }
}
