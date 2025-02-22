<?php

namespace App\Domain\Instrument\Share\Repository;

use App\Domain\Instrument\Share\Share;

interface ReadShareRepositoryInterface
{
    public function findByUid(string $uid): Share;
    public function getAll() : array;
}
