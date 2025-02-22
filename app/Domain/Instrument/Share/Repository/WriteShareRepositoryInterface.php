<?php

namespace App\Domain\Instrument\Share\Repository;

interface WriteShareRepositoryInterface
{
    public function saveAll(array $instruments);
    public function deleteByUid(string $uid);
    public function deleteAll();
}
