<?php

namespace App\Infrastructure\Repositories\Clickhouse\Market;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Application\Trade\DTOs\TradePeriodTimeDTO;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;
use App\Infrastructure\Adapters\ClickhouseAdapter;
use Google\Protobuf\Timestamp;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;

class ClickHouseTradeRepository implements TradeRepositoryInterface
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }

    public function save(\App\Application\Trade\DTOs\Market\TradeDTO $tradeDTO)
    {

    }

    public function getByTime(TradePeriodTimeDTO $periodTime): array
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(
                sql: '
                    SELECT * FROM trades WHERE time BETWEEN ' . $periodTime->beginTimeValue->getSeconds(). ' AND ' .$periodTime->endTimeValue->getSeconds() .' ORDER BY time DESC
                '
            );
            $exportData = [];
            $array_data = $data->rows();
            foreach ($array_data as $trade) {
                $data = new TradeDTO(
                    new TradeUidValue($trade['uid']),
                    new TradeDirectionValue($trade['direction']),
                    new TradePriceValue($trade['price']),
                    new TradeQuantityValue($trade['quantity']),
                    new TradeTimeValue(TradeTimeValue::fromStringToTimestamp($trade['time']))
                );
                $exportData[] = $data;

            }
            return $exportData;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getAll()
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(sql: '
                SELECT * FROM trades ;
            ');
            return $data->rows();

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(),
                code: $exception->getCode());
        }
    }

    public function getByUid(string $uid)
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(sql: '
            SELECT * FROM trades WHERE uid = ' . $uid . ';');
            $exportData = [];
            foreach ($data->rows() as $trade) {
                $exportData[] = TradeDTO::fromArray($trade);
            }
            return $exportData;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
