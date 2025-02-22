<?php

namespace App\Application\Instrument\Share\DTOs;

class SharesDTO
{
    public function __construct(
        public string $companyName,
        public string $ticker,

    )
    {
    }
}
