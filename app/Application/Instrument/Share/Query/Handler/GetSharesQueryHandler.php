<?php

namespace App\Application\Instrument\Share\Query\Handler;

use App\Application\Instrument\Share\Query\GetSharesQuery;
use App\Domain\Repositories\Share\Repository\ReadShareRepositoryInterface;

class GetSharesQueryHandler
{
    public function __construct(
        private readonly ReadShareRepositoryInterface $repository
    )
    {
    }

    public function __invoke(GetSharesQuery $query): array
    {

    }
}
