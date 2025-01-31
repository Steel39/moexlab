<?php

namespace App\Domain\Instrument\Share\ValueObject;

use App\Domain\Instrument\Share\ValueObject\ShareValueInterface;
readonly class ShareSectorValue implements ShareValueInterface
{
    public function __construct(
        private string $sector
    )
    {
    }

    public function getValue(): string
    {
        return $this->sector;
    }

}
