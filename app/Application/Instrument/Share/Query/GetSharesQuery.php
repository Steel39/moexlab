<?php

namespace App\Application\Instrument\Share\Query;

use App\Domain\ValueObjects\Sector;
use App\Domain\ValueObjects\InstrumentUid;

class GetSharesQuery
{
    /**
     * @param array<string, mixed> $filters Фильтры для запроса акций.
     */
    public function __construct(
        private readonly array $filters = []
    ) {
    }

    /**
     * Возвращает значение фильтра по ключу.
     *
     * @param string $key Ключ фильтра.
     * @return mixed|null Значение фильтра или null, если ключ не существует.
     */
    public function getFilter(string $key): mixed
    {
        return $this->filters[$key] ?? null;
    }

    /**
     * Проверяет, существует ли фильтр с указанным ключом.
     *
     * @param string $key Ключ фильтра.
     * @return bool
     */
    public function hasFilter(string $key): bool
    {
        return array_key_exists($key, $this->filters);
    }

    /**
     * Возвращает все фильтры.
     *
     * @return array<string, mixed>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}
