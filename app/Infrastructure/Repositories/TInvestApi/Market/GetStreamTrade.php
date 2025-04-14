<?php

namespace App\Infrastructure\Repositories\TInvestApi\Market;

use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Domain\Entity\Market\Trade;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\TradeDirection;
use App\Domain\ValueObjects\TradeTime;
use App\Domain\ValueObjects\Volume;
use App\Infrastructure\Adapters\TClientAdapter;
use Google\Protobuf\Internal\RepeatedField;
use Illuminate\Support\Facades\Log;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\SubscriptionAction;
use Tinkoff\Invest\V1\TradeInstrument;

class GetStreamTrade
{
    const TRADING_STATUS = 5; // Активный торговый статус
    const COUNTRY_OF_RISK = 'RU'; // Страна риска
    const STREAM_TIMEOUT = 120; // Таймаут в секундах (2 минуты)
    const MAX_RECONNECT_ATTEMPTS = 5; // Максимальное количество попыток переподключения
    const RECONNECT_DELAY = 5; // Задержка перед повторным подключением (в секундах)

    public function __construct(
        private readonly TClientAdapter $adapter,
        private readonly InstrumentsRequest $instrumentsRequest,
        private readonly SubscribeTradesRequest $subscribeTradesRequest,
        private readonly MarketDataRequest $marketDataRequest
    ) {
    }

    public function __invoke($command): void
    {
        $reconnectAttempts = 0;
        while ($reconnectAttempts < self::MAX_RECONNECT_ATTEMPTS) {
            try {
                Log::info('Attempting to start stream...');

                // Получаем список инструментов
                $instrumentServiceClient = $this->adapter->getClientFactory()->instrumentsServiceClient;

                $allInstruments = $this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_BASE);

                [$instrumentsServiceResponse, $instrumentsStatus] = $instrumentServiceClient
                ->Shares($allInstruments)
                ->wait();
                $requestedInstruments = $instrumentsServiceResponse->getInstruments();
                $tradingInstruments = $this->getTradesInstrument($requestedInstruments);


                // Создаем подписку на поток сделок
                $subscription = $this->getSubscription($tradingInstruments);
                $stream = $this->adapter->getClientFactory()->marketDataStreamServiceClient->MarketDataStream();
                $stream->write($subscription);

                Log::info('Start Stream of Trades: ' . date('Y-m-d H:i:s'));

                // Отслеживаем время последнего сообщения
                $lastMessageTime = time();

                // Обработка потока данных
                while (true) {
                    $marketDataResponse = $stream->read();

                    if ($marketDataResponse) {
                        // Обновляем время последнего сообщения
                        $lastMessageTime = time();

                        if ($trade = $marketDataResponse->getTrade()) {
                            // Преобразуем данные в доменную модель Trade
                            $tradeEntity = new Trade(
                                new InstrumentUid($trade->getInstrumentUid()),
                                TradeDirection::fromInt($trade->getDirection()),
                                new Price($trade->getPrice()),
                                new Volume($trade->getQuantity()),
                                TradeTime::fromTimestamp($trade->getTime())
                            );

                            $command->execute($tradeEntity);
                        }
                    }

                    // Проверяем таймаут потока
                    if (time() - $lastMessageTime > self::STREAM_TIMEOUT) {
                        Log::error('Stream timeout: No data received for ' . self::STREAM_TIMEOUT . ' seconds.');
                        break;
                    }
                }

                $stream->cancel();
                Log::info('End Stream: ' . date('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                Log::error('Stream error: ' . $e->getMessage());
            }

            // Увеличиваем счетчик попыток переподключения
            $reconnectAttempts++;

            if ($reconnectAttempts < self::MAX_RECONNECT_ATTEMPTS) {
                Log::info("Reconnecting in " . self::RECONNECT_DELAY . " seconds...");
                sleep(self::RECONNECT_DELAY);
            } else {
                Log::error('Max reconnect attempts reached. Stopping stream.');
                break;
            }
        }
    }

    /**
     * Фильтрует инструменты по торговому статусу и стране
     */
    private function getTradesInstrument(RepeatedField $requestedInstruments): array
    {
        $instruments = [];

        foreach ($requestedInstruments as $instrument) {
            $isTradingStatus = self::TRADING_STATUS === $instrument->getTradingStatus();
            $isCountryOfRisk = self::COUNTRY_OF_RISK === $instrument->getCountryOfRisk();

            if ($isTradingStatus && $isCountryOfRisk) {
                $tradeInstrument = new TradeInstrument();
                $tradeInstrument->setInstrumentId($instrument->getUid());
                $instruments[] = $tradeInstrument;
            }
        }

        if (empty($instruments)) {
            Log::error('No trading instruments found.');
            throw new \RuntimeException('No trading instruments found.');
        }
        return $instruments;
    }

    /**
     * Создает подписку на поток сделок
     */
    private function getSubscription(array $instruments): MarketDataRequest
    {
        $subscriptionTradesRequest = $this->subscribeTradesRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($instruments);

        return $this->marketDataRequest->setSubscribeTradesRequest($subscriptionTradesRequest);
    }
}
