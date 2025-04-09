<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

readonly class DifferentPrice
{
    private float $priceDifference;
    private float $priceChangePercentage;

    /**
     * @param Price $startPrice Начальная цена
     * @param Price $endPrice Конечная цена
     * @throws InvalidArgumentException Если начальная цена равна нулю
     */
    public function __construct(private readonly Price $startPrice, private readonly Price $endPrice)
    {
        if ($startPrice->getFloatPrice() == 0) {
            throw new InvalidArgumentException("Start price cannot be zero to calculate price change.");
        }

        // Вычисляем абсолютное изменение цены
        $this->priceDifference = $endPrice->getFloatPrice() - $startPrice->getFloatPrice();

        // Вычисляем изменение цены в процентах
        $this->priceChangePercentage = ($this->priceDifference / $startPrice->getFloatPrice()) * 100;
    }

    public function getStartPrice(): Price
    {
        return $this->startPrice;
    }

    public function getEndPrice(): Price
    {
        return $this->endPrice;
    }

    /**
     * Возвращает абсолютное изменение цены.
     */
    public function getDifference(): float
    {
        return round($this->priceDifference, 2);
    }

    /**
     * Возвращает изменение цены в процентах.
     */
    public function getChangePercentage(): float
    {
        return $this->priceChangePercentage;
    }
}
