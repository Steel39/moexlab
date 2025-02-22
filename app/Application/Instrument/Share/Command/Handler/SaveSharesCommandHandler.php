<?php

namespace App\Application\Instrument\Share\Command\Handler;

use App\Application\Instrument\Share\Command\SaveShareCommand;
use App\Domain\Instrument\Share\Repository\WriteShareRepositoryInterface;

readonly class SaveSharesCommandHandler
{
    public function __construct(
        private WriteShareRepositoryInterface $instrumentRepository
    )
    {
    }
    public function __invoke(SaveShareCommand $command): bool
    {
        return $this->instrumentRepository->saveAll($command->instruments);
    }
}
