<?php

namespace App\Domain\Repositories\Instrument\Share;

use App\Domain\Entity\Instrument\Share;

interface ApiShareRepositoryInterface
{

    /**
     * @return array<Share>
     */
    public function getShares(): array;

}
