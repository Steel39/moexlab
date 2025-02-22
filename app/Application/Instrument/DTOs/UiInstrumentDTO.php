<?php

namespace App\Application\Instrument\DTOs;

final readonly class UiInstrumentDTO
{
    public function __construct(
        public string $uid,
        public string $ticker,
        public string $name,
        public string $sector,
    )
    {
    }
}
