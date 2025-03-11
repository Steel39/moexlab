<?php

namespace App\Domain\Entity\Instrument;

use App\Domain\ValueObjects\Sector;
use App\Domain\ValueObjects\InstrumentUid;
use InvalidArgumentException;

final class Share
{
    private InstrumentUid $uid;
    private string $companyName;
    private string $ticker;
    private int $lot;
    private bool $shortEnabledFlag;
    private int $issueSize;
    private Sector $sector;
    private bool $divYieldFlag;

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
     */
    public function __construct(
        InstrumentUid $uid,
        string $companyName,
        string $ticker,
        int $lot,
        bool $shortEnabledFlag,
        int $issueSize,
        Sector $sector,
        bool $divYieldFlag
    ) {
        if ($lot <= 0) {
            throw new InvalidArgumentException('Lot size must be greater than zero.');
        }

        if ($issueSize <= 0) {
            throw new InvalidArgumentException('Issue size must be greater than zero.');
        }

        $this->uid = $uid;
        $this->companyName = $companyName;
        $this->ticker = $ticker;
        $this->lot = $lot;
        $this->shortEnabledFlag = $shortEnabledFlag;
        $this->issueSize = $issueSize;
        $this->sector = $sector;
        $this->divYieldFlag = $divYieldFlag;
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
}
