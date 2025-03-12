<?php

namespace App\Infrastructure\Repositories\TInvestApi\Market;

use App\Infrastructure\Adapters\TClientAdapter;
use Google\Protobuf\Timestamp;
use Tinkoff\Invest\V1\CandleInterval;
use Tinkoff\Invest\V1\GetCandlesRequest;
use Illuminate\Support\Facades\Log;
use const Grpc\STATUS_OK;

readonly class GetCandleByInterval
{
    const string TIME_PERIOD = '-1 week';
    public function __construct(
        private TClientAdapter $adapter
    ) {
    }

    public function __invoke($uid): void
    {
        // Проверяем, что UID не пустой
        if (empty($uid)) {
            throw new \InvalidArgumentException("Instrument UID cannot be empty.");
        }

        // Создаем временные метки
        $from = new Timestamp();
        $from->setSeconds(strtotime(self::TIME_PERIOD)); // Начало диапазона: неделя назад
        $from->setNanos(0);

        $to = new Timestamp();
        $to->setSeconds(time()); // Конец диапазона: текущее время
        $to->setNanos(0);

        // Получаем gRPC-клиент
        $instrumentServiceClient = $this->adapter->getClientFactory()->marketDataServiceClient;

        // Создаем запрос
        $candleRequest = new GetCandlesRequest();
        $candleRequest->setInstrumentId($uid)
            ->setFrom($from)
            ->setTo($to)
            ->setInterval(CandleInterval::CANDLE_INTERVAL_DAY);

        // Выполняем запрос
        [$candleServiceResponse, $status] = $instrumentServiceClient->GetCandles($candleRequest)->wait();

        // Проверяем статус
        if ($status->code !== STATUS_OK) {
            Log::error("gRPC request failed with status: " . $status->details);
            throw new \RuntimeException("gRPC request failed: " . $status->details);
        }

        // Проверяем, что ответ не пустой
        if (!$candleServiceResponse) {
            Log::error("Empty response received from the server.");
            throw new \RuntimeException("No response received from the server.");
        }

        // Извлекаем данные о свечах
        $candleInfo = $candleServiceResponse->getCandles();

        // Проверяем, что массив свечей не пустой
        if (empty($candleInfo)) {
            Log::info("No candles found for the given interval.");
            throw new \RuntimeException("No candles found for the given interval.");
        }

        // Считаем сумму объемов
        $sum = 0;
        foreach ($candleInfo as $item) {
            $sum += $item->getVolume();
        }

        // Выводим результат
        dd($sum);
    }
}
