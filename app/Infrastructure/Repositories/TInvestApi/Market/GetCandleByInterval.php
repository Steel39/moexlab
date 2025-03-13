<?php

namespace App\Infrastructure\Repositories\TInvestApi\Market;

use App\Domain\Repositories\Market\Candle\GetCandleByIntervalInterface;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\Entities\Market\Candle;
use Google\Protobuf\Timestamp;
use Tinkoff\Invest\V1\CandleInterval;
use App\Infrastructure\Adapters\TClientAdapter;
use Tinkoff\Invest\V1\GetCandlesRequest;
use Illuminate\Support\Facades\Log;
use const Grpc\STATUS_OK;
use App\Domain\ValueObjects\Volume;

class GetCandleByInterval implements GetCandleByIntervalInterface
{
    public function __construct(
        private readonly TClientAdapter $adapter
    ) {
    }

    /**
     * Получает свечи по интервалу.
     *
     * @param InstrumentUid $uid Идентификатор инструмента.
     * @param Timestamp $start Начало временного диапазона.
     * @param Timestamp $end Конец временного диапазона.
     * @return array Массив объектов свечей.
     * @throws \RuntimeException Если произошла ошибка при выполнении запроса.
     */
    public function getCandleByInterval(InstrumentUid $uid, Timestamp $start, Timestamp $end): Volume
    {
        if (!$uid instanceof InstrumentUid) {
            throw new \InvalidArgumentException("Invalid Instrument UID.");
        }

        // Получаем gRPC-клиент
        $instrumentServiceClient = $this->adapter->getClientFactory()->marketDataServiceClient;

        // Создаем запрос
        $candleRequest = new GetCandlesRequest();
        $candleRequest->setInstrumentId($uid->getValue())
                      ->setFrom($start)
                      ->setTo($end)
                      ->setInterval(CandleInterval::CANDLE_INTERVAL_HOUR);

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
            return new Volume(0);
        }

        // Преобразуем данные в массив объектов Candle
        $absoluteVolume = 0;
        foreach ($candleInfo as $item) {
            $absoluteVolume += $item->getVolume();
        }

        return new Volume($absoluteVolume);

    }
}
