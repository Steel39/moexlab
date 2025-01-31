<?php

namespace App\Domain\Market\Trade\ValueObject;

class TradeQuantityValue
{
    public function __construct(
        private readonly int $quantity
    )
    {
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
