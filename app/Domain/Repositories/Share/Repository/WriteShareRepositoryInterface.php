<?php

namespace App\Domain\Repositories\Share\Repository;

interface WriteShareRepositoryInterface
{
    public function saveAll(array $shares);
    public function deleteAll();
}
