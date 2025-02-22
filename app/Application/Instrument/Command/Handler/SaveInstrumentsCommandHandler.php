<?php

namespace App\Application\Instrument\Command\Handler;

use App\Application\Instrument\Command\SaveInstrumentsCommand;
use App\Domain\Instrument\InstrumentRepositoryInterface;

readonly class SaveInstrumentsCommandHandler
{
    public function __construct(
        private InstrumentRepositoryInterface $instrumentRepository
    )
    {
    }
    public function __invoke(SaveInstrumentsCommand $command): bool
    {
        return $this->instrumentRepository->saveAll($command->tableName, $command->instruments);
    }
}
