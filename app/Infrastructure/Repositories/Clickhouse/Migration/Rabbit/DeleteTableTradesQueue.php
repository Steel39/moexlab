<?php

namespace App\Infrastructure\Repositories\Clickhouse\Migration\Rabbit;

use App\Infrastructure\Adapters\ClickhouseAdapter;
use ClickHouseDB\Exception\ClickHouseException;

readonly class DeleteTableTradesQueue
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
            $connection->write('DROP TABLE IF EXISTS `trades`');
            $connection->write('DROP TABLE IF EXISTS `trades_queue`');
            $connection->write('DROP TABLE IF EXISTS `trade_consumer`');

        } catch (ClickhouseException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }
}
