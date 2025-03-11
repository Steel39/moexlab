<?php

namespace App\Domain\Repositories\Instrument\Share;

use App\Domain\Entity\Instrument\Share;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Sector;

interface ReadShareRepositoryInterface
{
    /**
     * Находит акцию по уникальному идентификатору.
     *
     * @param InstrumentUid $uid Уникальный идентификатор акции.
     * @return Share|null Возвращает объект Share или null, если акция не найдена.
     */
    public function findByUid(InstrumentUid $uid): ?Share;

    /**
     * Возвращает все акции.
     *
     * @return array<Share> Возвращает массив объектов Share.
     */
    public function getAll(): array;

    /**
     * Возвращает акции, отфильтрованные по сектору.
     *
     * @param Sector $sector Сектор для фильтрации.
     * @return array<Share> Возвращает массив объектов Share.
     */
    public function findBySector(Sector $sector): array;
}
