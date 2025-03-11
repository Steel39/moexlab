<?php

namespace App\Application\Instrument\Share\DTOs;

use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Sector;

final class SharesDTO
{
    public function __construct(
        public readonly InstrumentUid $uid,
        public readonly string $companyName,
        public readonly string $ticker,
        public readonly int $lot,
        public readonly bool $shortEnabledFlag,
        public readonly int $issueSize,
        public readonly Sector $sector,
        public readonly bool $divYieldFlag
    ) {
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid->getValue(),
            'company_name' => $this->companyName,
            'ticker' => $this->ticker,
            'lot' => $this->lot,
            'short_enabled_flag' => $this->shortEnabledFlag,
            'issue_size' => $this->issueSize,
            'sector' => $this->sector->toString(),
            'div_yield_flag' => $this->divYieldFlag,
        ];
    }
}
