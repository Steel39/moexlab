<?php

namespace App\Infrastructure\Repositories\Clickhouse\Migration\TInvestApi\Instrument\Shares;

use App\Infrastructure\Adapters\ClickhouseAdapter;
use ClickHouseDB\Exception\ClickHouseException;

class CreateTableShares
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }

    public function createTableShares(string $tableName = 'shares'): void
    {
        try {
            $connection = $this->adapter->getConnection();
            $query = "CREATE TABLE IF NOT EXISTS $tableName (
                    uid String,
                    company_name String,
                    ticker String,
                    lot UInt32,
                    short_enabled_flag Bool,
                    issue_size UInt64,
                    sector String,
                    div_yield_flag Bool
                  ) ENGINE = MergeTree()
                  ORDER BY (uid);";
            $connection->write($query);
            echo "Table $tableName created\n";
        } catch (ClickhouseException $e) {
            error_log($e->getMessage(), $e->getTrace());
        }

    }

}
