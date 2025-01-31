<?php

namespace App\Infrastructure\Repositories\Clickhouse\Market;

use App\Application\Trade\DTOs\Market\TradeDTO;
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

    public function save(\App\Application\Trade\DTOs\Market\TradeDTO $tradeDTO)
    {

    }

    public function getByTime(TradeTimeValue $beginTime, TradeTimeValue $endTime): array
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(
                sql: '
                    SELECT * FROM trades WHERE time BETWEEN ' . $beginTime->getSeconds() . ' AND ' . $endTime->getSeconds() .' ORDER BY time DESC
                '
            );
            $exportData = [];
            $array_data = $data->rows();
            foreach ($array_data as $trade) {
                $data = new TradeDTO(
                    new TradeUidValue($trade->instrument_uid),
                    new TradeDirectionValue($trade->direction),
                    new TradePriceValue($trade->price),
                    new TradeQuantityValue($trade->quantity),
                    new TradeTimeValue($trade->time),
                );
                $exportData[] = $data;
            }

            return $exportData;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public
    function getAll()
    {
        try {
            $connection = $this->adapter->getConnection();
            $data = $connection->select(sql: '
                SELECT * FROM trades ;
            ');
            return $data->rows();

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception);
        }


    }
}
