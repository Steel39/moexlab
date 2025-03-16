<?php

namespace App\Infrastructure\Repositories\Clickhouse\Market;

use App\Application\Market\Trade\DTOs\Market\TotalVolumeTradesDTO;
use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;
use App\Domain\Market\Trade\TradeRepositoryInterface;
use App\Domain\Market\Trade\ValueObject\TradeDirectionValue;
use App\Domain\Market\Trade\ValueObject\TradePriceValue;
use App\Domain\Market\Trade\ValueObject\TradeQuantityValue;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\Market\Trade\ValueObject\TradeUidValue;
use App\Infrastructure\Adapters\ClickhouseAdapter;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;

class ClickHouseTradeRepository implements TradeRepositoryInterface
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }

    public function save(\App\Application\Market\Trade\DTOs\Market\TradeDTO $tradeDTO)
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
                $data = new \App\Application\Market\Trade\DTOs\Market\TradeDTO(
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
                $exportData[] = \App\Application\Market\Trade\DTOs\Market\TradeDTO::fromArray($trade);
            }
            return $exportData;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return  array
     */
    public function getSumTrades(TradePeriodTimeDTO $periodTime): array
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(sql:  '
                SELECT
                    uid,
                    SUM(CASE WHEN direction = 1 THEN quantity ELSE 0 END) AS total_buy,
                    SUM(CASE WHEN direction = 2 THEN quantity ELSE 0 END) AS total_sell,
                    argMin(price, time) AS start_price,
                    argMax(price, time) AS end_price
                FROM (
                    SELECT
                        uid,
                        quantity,
                        price,
                        time,
                        direction,
                        min(time) OVER (PARTITION BY uid) AS min_time,
                        max(time) OVER (PARTITION BY uid) AS max_time
                    FROM trades
                    WHERE time BETWEEN ' . $periodTime->beginTimeValue->getSeconds() . ' AND ' . $periodTime->endTimeValue->getSeconds() . '
                ) AS subquery
                GROUP BY uid
                FORMAT JSON
');
        } catch (\Exception $exception)
        {
            throw new Exception($exception->getMessage());
        }
        $tradesDto = [];
        $trades = $data->rows();
        foreach ($trades as $trade) {
            $tradeDTO = TotalVolumeTradesDTO::fromArray($trade);
            $tradesDto[] = $tradeDTO;
        }
        return $tradesDto;
    }


}
