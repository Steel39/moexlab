<?php

namespace App\Application\Instrument\Share\Command\Handler;

use App\Application\Instrument\Share\Command\UpdateWeeklyVolumesCommand;
use App\Domain\Repositories\Market\Candle\GetCandleByIntervalInterface;
use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use Google\Protobuf\Timestamp;

final readonly class UpdateWeeklyVolumesCommandHandler
{
    public function __construct(
        private ReadShareRepositoryInterface $instrumentRepository,
        private GetCandleByIntervalInterface $volumeApiRepository,
        private WriteShareRepositoryInterface $shareRepository
    ) {
    }

    /**
     * Обрабатывает команду на обновление недельных объемов.
     *
     * @param UpdateWeeklyVolumesCommand $command Команда.
     */
    public function __invoke(UpdateWeeklyVolumesCommand $command): void
    {
        // Получаем список всех акций
        $instruments = $this->instrumentRepository->getAll();

        $period = self::getLastWeekPeriod();
        // Определяем временной диапазон (например, за последнюю неделю)
        $from = new Timestamp();
        $from->setSeconds($period['from']);
        $to = new Timestamp();
        $to->setSeconds($period['to']);

        $updates = [];
        foreach ($instruments as $instrument) {
            // Запрашиваем объемы для каждой акции через API
            $weeklyVolume = $this->volumeApiRepository->getCandleByInterval($instrument->getUid(), $from, $to);

            // Добавляем данные для обновления
            $updates[] = [
                'uid' => $instrument->getUid()->getValue(),
                'volume' => $weeklyVolume
            ];
            echo $instrument->getTicker() . ' - ' . $weeklyVolume . ' - ' . $instrument->getUid()->getValue() . PHP_EOL;
        }

        // Массовое обновление в БД
        $this->shareRepository->bulkUpdateWeeklyVolumes($updates);
    }

    private static function getLastWeekPeriod(): array
{
    $now = new \DateTimeImmutable('now');

    // Начало периода: полночь текущего дня минус 7 дней
    $fromDate = $now->modify('today midnight -7 days');

    // Конец периода: полночь текущего дня (исключая сегодняшний день)
    $toDate = $now->modify('today midnight');

    return [
        'from' => $fromDate->getTimestamp(),
        'to' => $toDate->getTimestamp(),
    ];
}
}
