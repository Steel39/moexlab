<?php

namespace App\Infrastructure\Repositories\TInvestApi\Market;

use App\Infrastructure\Adapters\TClientAdapter;
use Google\Protobuf\Timestamp;
use Tinkoff\Invest\V1\CandleInterval;
use Tinkoff\Invest\V1\GetCandlesRequest;

class GetCandleByInterval
{
    public function __construct(
        private readonly TClientAdapter $adapter
    )
    {

    }

    public function __invoke($uid)
    {
        $from = new Timestamp();
        $from->setSeconds(strtotime('-1 week'));
        $to = new TimeStamp();
        $to->setSeconds(time());
        $instrumentServiceClient = $this->adapter->getClientFactory()->marketDataServiceClient;
        $candleRequest = new GetCandlesRequest();
        [$candleServiceResponse, $status] = $instrumentServiceClient->GetCandles(
            $candleRequest->setInstrumentId($uid)->setFrom($from)->setTo($to)
                                    ->setInterval(CandleInterval::CANDLE_INTERVAL_WEEK))
                                    ->wait();
        dd($candleServiceResponse->getCandles());
    }
}
