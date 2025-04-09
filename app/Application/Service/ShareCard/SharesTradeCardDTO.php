<?php

namespace App\Application\Service\ShareCard;

use App\Domain\ValueObjects\DifferentPrice;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\RelativeVolume;
use App\Domain\ValueObjects\Volume;

class SharesTradeCardDTO
{
    /**
     * @param InstrumentUid $uid Уникальный идентификатор инструмента
     * @param string $ticker Тикер акции
     * @param string $name Название акции
     * @param string $sector Сектор, к которому относится акция
     * @param Volume $buyVolume Объем покупок
     * @param Volume $sellVolume Объем продаж
     * @param DifferentPrice $differentPrice Изменение цены
     * @param RelativeVolume $relativeVolume Относительный объем
     */
    public function __construct(
        public readonly InstrumentUid $uid,
        public readonly string $ticker,
        public readonly string $name,
        public readonly string $sector,
        public readonly Volume $buyVolume,
        public readonly Volume $sellVolume,
        public readonly DifferentPrice $differentPrice,
        public readonly RelativeVolume $relativeVolume,
        public readonly Price $averagePriceBuy,
        public readonly Price $averagePriceSell
    ) {
    }

    /**
     * Преобразует DTO в массив для удобства работы (например, для JSON).
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid->toString(),
            'ticker' => $this->ticker,
            'name' => $this->name,
            'sector' => $this->sector,
            'buy_volume' => $this->buyVolume->getValue(),
            'sell_volume' => $this->sellVolume->getValue(),
            'firstPrice' => $this->differentPrice->getStartPrice(),
            'endPrice' => $this->differentPrice->getEndPrice(),
            'price_difference' => $this->differentPrice->getDifference(),
            'price_change_percentage' => $this->differentPrice->getChangePercentage(),
            'relative_volume' => $this->relativeVolume->getValue(),
            'relative_volume_percentage' => $this->relativeVolume->getPercentage(),
            'average_price_buy' => $this->averagePriceBuy->getFloatPrice(),
            'average_price_sell' => $this->averagePriceSell->getFloatPrice(),
        ];
    }
}
