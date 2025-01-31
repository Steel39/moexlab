<?php

namespace App\Infrastructure\Repositories\TInvestApi\Instrument\Shares;

use App\Domain\Instrument\Share\Share;
use App\Infrastructure\Adapters\TClientAdapter;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;

class TInvestSharesRepository
{
    const COUNTRY_OF_RISK = 'RU';
    const TRADING_STATUS = 5;


    public function __construct(
        private readonly TClientAdapter     $adapter,
        private readonly InstrumentsRequest $request,
    )
    {
    }

    public function getShares(): array
    {
        [$response, $status] = $this->adapter->getClientFactory()
            ->instrumentsServiceClient
            ->Shares($this->request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();
        $instruments = $response->getInstruments();
        if (empty($instruments)) {
            return $status;
        }
        $instrumentsDictionary = [];
        foreach ($instruments as $instrument) {
            if ($instrument->getCountryOfRisk() === self::COUNTRY_OF_RISK && $instrument->getTradingStatus() === self::TRADING_STATUS)
            {
                $instrumentsDictionary[] = new Share(
                    $instrument->getUid(),
                    $instrument->getName(),
                    $instrument->getTicker(),
                    $instrument->getLot(),
                    $instrument->getShortEnabledFlag(),
                    $instrument->getIssueSize(),
                    $instrument->getSector(),
                    $instrument->getDivYieldFlag(),
                );
            }

        }
        return $instrumentsDictionary;
    }
}
