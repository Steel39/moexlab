<?php

namespace App\Application\Instrument\Share\Command\Handler;

use App\Application\Instrument\Share\Command\DeleteSharesCommand;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;

final readonly class DeleteSharesCommandHandler
{
    public function __construct(
        private WriteShareRepositoryInterface $repository
    ) {
    }

    public function __invoke(DeleteSharesCommand $command): void
    {

        $this->repository->deleteAll();
    }
}
