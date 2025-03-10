<?php

namespace App\Domain\Repositories\Share\ValueObject;

use App\Domain\Instrument\Share\ValueObject\ShareValueInterface;
use Tinkoff\Invest\V1\SecurityTradingStatus;

readonly class ShareTradingStatusValue implements ShareValueInterface
{
    public function __construct(
        public readonly int $tradingStatus,
    )
    {
    }

    public function toString(): string
    {
        return SecurityTradingStatus::name($this->tradingStatus);
    }

}
