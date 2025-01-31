<?php

namespace App\Infrastructure\Repositories\TInvestApi\Market;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;
use App\Infrastructure\Adapters\TClientAdapter;
use App\Infrastructure\Repositories\Messaging\Trade\TradeMessagePublish;
use Illuminate\Support\Facades\Log;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\SubscriptionAction;
use Tinkoff\Invest\V1\TradeInstrument;

class GetStreamTrade
{
    const TRADING_STATUS = 5;
    const COUNTRY_OF_RISK = 'RU';

    public function __construct(
        private readonly TClientAdapter         $adapter,
        private readonly InstrumentsRequest     $instrumentsRequest,
        private readonly SubscribeTradesRequest $subscribeTradesRequest,
        private readonly MarketDataRequest      $marketDataRequest,
        private readonly TradeMessagePublish    $tradeMessagePublish,
    )
    {
    }

    public function __invoke($command)
    {
        $instrumentServiceClient = $this->adapter->getClientFactory()->instrumentsServiceClient;
        $allInstruments = $this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        [$instrumentsServiceResponse, $instrumentsStatus] = $instrumentServiceClient
            ->Shares($allInstruments)
            ->wait();
        $requestedInstruments = $instrumentsServiceResponse->getInstruments();
        $instruments = $this->getTradesInstrument($requestedInstruments);
        $subscription = $this->getSubscription($instruments);
        $stream = $this->adapter->getClientFactory()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($subscription);
        Log::info('start Stream of Trades: ' . date('h:i:s'));

        while($marketDataResponse = $stream->read()){
            if($trade = $marketDataResponse->getTrade())  {
                $tradeDto = new TradeDTO(
                    new TradeUidValue($trade->getInstrumentUid()),
                    new TradeDirectionValue($trade->getDirection()),
                    new TradePriceValue($trade->getPrice()),
                    new TradeQuantityValue($trade->getQuantity()),
                    new TradeTimeValue($trade->getTime()),
                );
                $command->execute($tradeDto);
            };
        }
        $stream->cancel();
        Log::info('End Stream: '. date('h:i:s'));

    }

    public function getTradesInstrument(mixed $requestedInstruments): array
    {
        $instruments = [];
        foreach ($requestedInstruments as $requestedInstrument) {
            $isTradingStatus = self::TRADING_STATUS === $requestedInstrument->getTradingStatus();
            $isCountryOfRisc = self::COUNTRY_OF_RISK === $requestedInstrument->getCountryOfRisk();

            if ($isTradingStatus && $isCountryOfRisc) {
                $tradeInstrument = new TradeInstrument();
                $tradeInstrument->setInstrumentId($requestedInstrument->getUid());
                $instruments[] = $tradeInstrument;
            }
        }
        if (empty($instruments)) {
            die('Instruments not found' .  PHP_EOL);
        }
        return $instruments;
    }

    private function getSubscription(array $instruments): MarketDataRequest
    {
        $subscriptionTradesRequest = $this->subscribeTradesRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($instruments);
        return $this->marketDataRequest->setSubscribeTradesRequest($subscriptionTradesRequest);
    }
}
