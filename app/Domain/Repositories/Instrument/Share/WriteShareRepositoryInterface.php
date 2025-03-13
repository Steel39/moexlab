<?php

namespace App\Domain\Repositories\Instrument\Share;

use App\Domain\Entity\Instrument\Share;
use App\Domain\ValueObjects\InstrumentUid;
use InvalidArgumentException;

interface WriteShareRepositoryInterface
{
    /**
     * Сохраняет одну или несколько акций в хранилище.
     *
     * @param Share[] $shares Массив объектов Share для сохранения.
     * @return void
     * @throws InvalidArgumentException Если массив содержит некорректные данные.
     */
    public function saveAll(array $shares): void;

    /**
     * Удаляет все акции из хранилища.
     *
     * @return void
     */
    public function deleteAll(): void;

    /**
     * Сохраняет одну акцию в хранилище.
     *
     * @param Share $share Объект Share для сохранения.
     * @return void
     */
    public function save(Share $share): void;

    /**
     * Удаляет одну акцию из хранилища по уникальному идентификатору.
     *
     * @param string $uid Уникальный идентификатор акции.
     * @return void
     */
    public function deleteByUid(string $uid): void;


    /**
     * Массовое обновление недельных объемов.
     *
     * @param array $updates Массив данных для обновления.
     */
    public function bulkUpdateWeeklyVolumes(array $updates): void;

}
