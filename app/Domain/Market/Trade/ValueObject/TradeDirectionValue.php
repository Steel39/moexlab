<?php

namespace App\Domain\Market\Trade\ValueObject;
use Tinkoff\Invest\V1\TradeDirection;

readonly class TradeDirectionValue
{
    public function __construct(
        private int $direction
    )
    {
    }

    public function toInt(): int
    {
        return $this->direction;
    }
    public function toString(): string
    {
        return TradeDirection::name(self::toInt());
    }


}
