<?php

namespace App\Infrastructure\Repositories\TInvestApi\Instrument\Shares;

use App\Domain\Entity\Instrument\Share;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Sector;
use App\Infrastructure\Adapters\TClientAdapter;
use Google\Protobuf\Internal\RepeatedField;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use InvalidArgumentException;

class TInvestSharesRepository
{
    const COUNTRY_OF_RISK = 'RU';
    const TRADING_STATUS = 5;
    const INSTRUMENT_STATUS = InstrumentStatus::INSTRUMENT_STATUS_ALL;

    public function __construct(
        private readonly TClientAdapter $adapter,
        private readonly InstrumentsRequest $request
    ) {
    }

    /**
     * Получает список акций из API Tinkoff Invest.
     *
     * @return array<Share> Массив объектов Share.
     * @throws InvalidArgumentException Если данные из API некорректны.
     */
    public function getShares(): array
    {
        [$response, $status] = $this->adapter->getClientFactory()
            ->instrumentsServiceClient
            ->Shares($this->request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();

        $instruments = $response->getInstruments();
        if (empty($instruments)) {
            return [];
        }

        return $this->filterAndTransformInstruments($instruments);
    }

    /**
     * Фильтрует и преобразует данные из API в массив объектов Share.
     *
     * @param array $instruments Данные из API.
     * @return array<Share> Массив объектов Share.
     * @throws InvalidArgumentException Если данные из API некорректны.
     */
    private function filterAndTransformInstruments(RepeatedField $instruments): array
    {
        $shares = [];
        foreach ($instruments as $instrument) {
            if (
                $instrument->getCountryOfRisk() === self::COUNTRY_OF_RISK &&
                $instrument->getTradingStatus() === self::TRADING_STATUS
            ) {
                try {
                    $shares[] = new Share(
                        new InstrumentUid($instrument->getUid()),
                        $instrument->getName(),
                        $instrument->getTicker(),
                        (int)$instrument->getLot(),
                        (bool)$instrument->getShortEnabledFlag(),
                        (int)$instrument->getIssueSize(),
                        new Sector($instrument->getSector()),
                        (bool)$instrument->getDivYieldFlag()
                    );
                } catch (InvalidArgumentException $e) {
                    error_log("Invalid sector display name for Share with UID: {$instrument->getUid()}. Display name: {$instrument->getSector()}. Error: {$e->getMessage()}");
                    continue; // Пропускаем некорректную акцию
                }
            }
        }
        return $shares;
    }
}
