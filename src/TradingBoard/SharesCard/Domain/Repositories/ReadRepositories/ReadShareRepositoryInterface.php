<?php

namespace Src\TradingBoard\SharesCard\Domain\Repositories\ReadRepositories;

interface ReadShareRepositoryInterface
{
    public function getAll();
    public function getByUid();

}
