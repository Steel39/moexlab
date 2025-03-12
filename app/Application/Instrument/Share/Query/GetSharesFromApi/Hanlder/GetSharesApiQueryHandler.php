<?php

namespace App\Application\Instrument\Share\Query\GetSharesFromApi\Hanlder;


use App\Application\Instrument\Share\Query\GetSharesFromApi\GetSharesApiQuery;
use App\Domain\Repositories\Instrument\Share\ApiShareRepositoryInterface;
use App\Domain\Entity\Instrument\Share;

class GetSharesApiQueryHandler
{
    public function __construct(
        private readonly ApiShareRepositoryInterface $apiShareRepository
    ) {

    }

    /**
     * Summary of __invoke
     * @param GetSharesApiQuery $query
     * @return array<Share>
     */
    public function __invoke(GetSharesApiQuery $query): array
    {
        if (empty($query->params)) {
            $shares = $this->apiShareRepository->getShares();
        }
        return $shares;
    }
}
