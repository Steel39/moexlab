<?php

namespace App\Domain\Entity\Instrument;

use App\Domain\ValueObjects\Sector;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Volume;
use InvalidArgumentException;

final class Share
{
    /**
     * Конструктор с валидацией.
     *
     * @param InstrumentUid $uid
     * @param string $companyName
     * @param string $ticker
     * @param int $lot
     * @param bool $shortEnabledFlag
     * @param int $issueSize
     * @param Sector $sector
     * @param bool $divYieldFlag
     * @param Volume $volume
     */
    public function __construct(
        private readonly InstrumentUid $uid,
        private readonly string $companyName,
        private readonly string $ticker,
        private readonly int $lot,
        private readonly bool $shortEnabledFlag,
        private readonly int $issueSize,
        private readonly Sector $sector,
        private readonly bool $divYieldFlag,
        private readonly Volume $volume
    ) {
        if ($lot <= 0) {
            throw new InvalidArgumentException('Lot size must be greater than zero.');
        }

        if ($issueSize <= 0) {
            throw new InvalidArgumentException('Issue size must be greater than zero.');
        }
    }

    /**
     * Возвращает уникальный идентификатор.
     *
     * @return InstrumentUid
     */
    public function getUid(): InstrumentUid
    {
        return $this->uid;
    }

    /**
     * Возвращает название компании.
     *
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * Возвращает тикер.
     *
     * @return string
     */
    public function getTicker(): string
    {
        return $this->ticker;
    }

    /**
     * Возвращает размер лота.
     *
     * @return int
     */
    public function getLot(): int
    {
        return $this->lot;
    }

    /**
     * Проверяет, разрешены ли короткие продажи.
     *
     * @return bool
     */
    public function isShortSellingAllowed(): bool
    {
        return $this->shortEnabledFlag;
    }

    /**
     * Возвращает размер выпуска акций.
     *
     * @return int
     */
    public function getIssueSize(): int
    {
        return $this->issueSize;
    }

    /**
     * Возвращает сектор.
     *
     * @return Sector
     */
    public function getSector(): Sector
    {
        return $this->sector;
    }

    /**
     * Проверяет, выплачивается ли дивиденд.
     *
     * @return bool
     */
    public function hasDividendYield(): bool
    {
        return $this->divYieldFlag;
    }

    public function getVolume(): Volume
    {
        return $this->volume;
    }
}
