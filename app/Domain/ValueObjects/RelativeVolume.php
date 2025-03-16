<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

readonly class RelativeVolume
{
    private float $relativeVolume;

    /**
     * @param Volume $absoluteVolume Абсолютный объем
     * @param Volume $actualVolume Фактический объем
     * @throws InvalidArgumentException Если фактический объем равен нулю
     */
    public function __construct(private Volume $absoluteVolume, private Volume $actualVolume)
    {
        if ($actualVolume->getValue() === 0) {
            throw new InvalidArgumentException("Actual volume cannot be zero to calculate relative volume.");
        }

        // Вычисляем относительный объем
        $averageDailyVolume = new Volume($absoluteVolume->getValue()/7);
        $this->relativeVolume =  $this->actualVolume->getValue() / $averageDailyVolume->getValue();
    }

    /**
     * Возвращает относительный объем как десятичное число.
     */
    public function getValue(): float
    {
        return round($this->relativeVolume, 2);
    }

    /**
     * Возвращает относительный объем в процентах.
     */
    public function getPercentage(): float
    {
        return $this->relativeVolume * 100;
    }
}
