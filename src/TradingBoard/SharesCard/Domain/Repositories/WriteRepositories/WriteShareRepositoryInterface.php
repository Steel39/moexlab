<?php

namespace Src\TradingBoard\SharesCard\Domain\Repositories\WriteRepositories;

interface WriteShareRepositoryInterface
{
    public function saveAll();
    public function save();
    public function updateAll();
    public function delete();
    public function deleteAll();
}
