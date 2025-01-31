<?php

namespace App\Domain\Instrument\Share;

use Tinkoff\Invest\V1\SecurityTradingStatus;

readonly class Share
{
    public function __construct(
        public string $uid,
        public string $companyName,
        public string $ticker,
        public int    $lot,
        public bool   $shortEnabledFlag,
        public int    $issueSize,
        public string $sector,
        public bool   $divYieldFlag,
    )
    {
    }

    public function toArray (): array
    {
        return  ['uid' => $this->uid,
        'company_name' => $this->companyName,
        'ticker' => $this->ticker,
        'lot' => $this->lot,
        'short_enabled_flag' => $this->shortEnabledFlag,
        'issue_size' => $this->issueSize,
        'sector' => $this->sector,
        'div_yield_flag' => $this->divYieldFlag];
    }
}
