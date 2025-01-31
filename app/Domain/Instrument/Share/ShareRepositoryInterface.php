<?php

namespace App\Domain\Instrument\Share;

use App\Domain\Instrument\Share\Share;
interface ShareRepositoryInterface
{
    public function save(Share $share);
    public function saveAll(array $shares);
    public function findByUid(string $uid): Share;
    public function getAll() : array;
    public function delete(Share $share);
    public function deleteAll();
}
