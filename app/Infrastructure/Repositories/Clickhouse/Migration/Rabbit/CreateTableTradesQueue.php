<?php

namespace App\Infrastructure\Repositories\Clickhouse\Migration\Rabbit;

use App\Infrastructure\Adapters\ClickhouseAdapter;
use PhpClickHouseLaravel\Migration;

class CreateTableTradesQueue
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }

    public function creatTableTradesQueue(string $tableName = 'trades'): void
    {
        try {
            $connection = $this->adapter->getConnection();

            // Создание таблицы trades
            $connection->write(
                sql: '
                CREATE TABLE IF NOT EXISTS trades (
                    uid String,
                    direction Int,
                    price Float,
                    quantity Int,
                    time TIMESTAMP
                ) ENGINE = MergeTree() ORDER BY time;
            '
            );

            // Создание таблицы 1
            $connection->write(
                sql: '
                CREATE TABLE IF NOT EXISTS trades_queue (
                    uid String,
                    direction Int,
                    price Float,
                    quantity Int,
                    time TIMESTAMP
                ) ENGINE = RabbitMQ SETTINGS
                    rabbitmq_host_port = \'lab_rabbit\',
                    rabbitmq_exchange_name = \'market\',
                    rabbitmq_exchange_type = \'direct\',
                    rabbitmq_routing_key_list = \'trades_queue\',
                    rabbitmq_format = \'JSONEachRow\',
                    rabbitmq_password = \'pass\',
                    rabbitmq_username = \'steel\'
            '
            );

            // Создание материализованного представления consumer
            $connection->write(
                sql: '
                CREATE MATERIALIZED VIEW IF NOT EXISTS trade_consumer TO trades AS
                SELECT uid, direction, price, quantity, time FROM trades_queue
            '
            );
        } catch (\ClickHouseDB\Exception\DatabaseException $e) {
            error_log($e->getMessage());
        }
    }
}


