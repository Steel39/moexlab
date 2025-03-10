<?php

namespace App\Domain\Repositories\Share\ValueObject;

readonly class ShareSectorValue
{
    const array ENERGY_SECTOR = [
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
        '' => 'Сектор неопределен',
];
    public function __construct(
        public string $sector
    )
    {
    }

    public function getSectorName(): string
    {
        return self::ENERGY_SECTOR[ $this->sector ];
    }

}
