<?php

namespace App\Domain\Instrument\Share\ValueObject;

use Tinkoff\Invest\V1\SecurityTradingStatus;

readonly class ShareTradingStatusValue implements ShareValueInterface
{
    public function __construct(
        private readonly int $tradingStatus,
    )
    {
    }
    public function getValue(): int
    {
        return $this->tradingStatus;
    }

    public function toString(): string
    {
        return SecurityTradingStatus::name($this->tradingStatus);
    }

}
