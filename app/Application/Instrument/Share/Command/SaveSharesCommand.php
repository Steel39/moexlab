<?php

namespace App\Application\Instrument\Share\Command;

use App\Domain\Entity\Instrument\Share;

readonly class SaveSharesCommand
{
    /**
     * @param array<Share> $shares
     */
    public function __construct(private array $shares)
    {
    }

    /**
     * @return array<Share>
     */
    public function getShares(): array
    {
        return $this->shares;
    }
}
