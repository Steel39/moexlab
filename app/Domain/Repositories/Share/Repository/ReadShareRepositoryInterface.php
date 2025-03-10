<?php

namespace App\Domain\Repositories\Share\Repository;

use App\Domain\Repositories\Share\Share;

interface ReadShareRepositoryInterface
{
    public function findByUid(string $uid): Share;
    public function getAll() : array;
}
