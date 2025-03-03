<?php

namespace App\Domain\Instrument\Share\Repository;

interface WriteShareRepositoryInterface
{
    public function saveAll(array $shares);
    public function deleteAll();
}
