<?php

namespace App\Infrastructure\Repositories\Clickhouse\Migration\TInvestApi\Instrument\Shares;

use App\Infrastructure\Adapters\ClickhouseAdapter;
use ClickHouseDB\Exception\DatabaseException;

class DeleteSharesTable
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }

    public function down(): void
    {
        try {
            $connection = $this->adapter->getConnection();
            $query = "
            DROP TABLE IF EXISTS `shares`;
            ";
            $connection->write($query);
            echo "Migrate Rollback";
        } catch (DatabaseException $e) {
            error_log($e->getMessage(), $e->getTrace());
        }
    }
}
