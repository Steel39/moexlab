<?php

namespace App\Application\Instrument\Share\Query\Handler;

use App\Application\Instrument\Share\DTOs\SharesDTO;
use App\Application\Instrument\Share\Query\GetSharesQuery;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Entity\Instrument\Share;

class GetSharesQueryHandler
{
    public function __construct(
        private readonly ReadShareRepositoryInterface $repository
    ) {
    }

    public function __invoke(GetSharesQuery $query): array
    {
        $filters = $query->getFilters();

        if (isset($filters['sector'])) {
            $shares = $this->repository->findBySector($filters['sector']);
        } else {
            $shares = $this->repository->getAll();
        }

        // Преобразуем массив объектов Share в массив DTO
        return array_map(fn(Share $share) => new SharesDTO(
            $share->getUid(),
            $share->getCompanyName(),
            $share->getTicker(),
            $share->getLot(),
            $share->isShortSellingAllowed(),
            $share->getIssueSize(),
            $share->getSector(),
            $share->hasDividendYield(),
            $share->getVolume()
        ), $shares);
    }
}
