<?php

namespace App\Application\Instrument\Share\Query\Handler;

use App\Application\Instrument\Share\Query\GetSharesQuery;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Entity\Instrument\Share;

class GetSharesQueryHandler
{
    public function __construct(
        private readonly ReadShareRepositoryInterface $shareRepository
    ) {
    }

    /**
     * Обрабатывает запрос на получение акций.
     *
     * @param GetSharesQuery $query Запрос с фильтрами для получения акций.
     * @return Share[] Массив объектов Share.
     */
    public function __invoke(GetSharesQuery $query): array
    {
        $filters = $query->getFilters();

        if ($query->hasFilter('sector')) {
            $sector = $filters['sector'];
            return $this->shareRepository->findBySector($sector);
        }

        if ($query->hasFilter('uid')) {
            $uid = $filters['uid'];
            $share = $this->shareRepository->findByUid($uid);
            return $share ? [$share] : [];
        }

        // Если фильтры отсутствуют, возвращаем все акции
        return $this->shareRepository->getAll();
    }
}
