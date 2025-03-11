<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class Sector
{
    private const array VALID_SECTORS = [
        'energy' => 'Энергетический',
        'utilities' => 'Снабжение',
        'industrials' => 'Промышленный',
        'consumer' => 'Потребительский',
        'it' => 'Информационные технологии',
        'materials' => 'Производственный',
        'financial' => 'Финансовый',
        'health_care' => 'Здоровье и медицина',
        'telecom' => 'Коммуникации',
        'real_estate' => 'Недвижимость',
        'other' => 'Другие',
    ];

    private string $sector;

    public function __construct(string $sector)
    {
        if (empty($sector)) {
            $sector = 'other';
        }

        if (!array_key_exists($sector, self::VALID_SECTORS)) {
            throw new InvalidArgumentException("Invalid sector key: {$sector}");
        }

        $this->sector = $sector;
    }

    public function getSector(): string
    {
        return $this->sector;
    }

    public function toString(): string
    {
        return self::VALID_SECTORS[$this->sector];
    }

}
