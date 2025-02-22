<?php

namespace App\Application\Instrument\Query\Handler;

use App\Application\Instrument\Query\GetInstrumentsQuery;
use App\Domain\Instrument\InstrumentRepositoryInterface;

class GetInstrumentsQueryHandler
{
    public function __construct(
        private readonly InstrumentRepositoryInterface $instrumentRepository
    )
    {
    }

    public function __invoke(GetInstrumentsQuery $query): array
    {
        return $this->instrumentRepository->getAll($query->tableName);
    }
}
