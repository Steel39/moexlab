<?php

namespace App\Infrastructure\Adapters;

use ClickHouseDB\Client;

final readonly class ClickhouseAdapter
{
    public function getConnection(): Client
    {
        return new Client(
            config('database.connections.clickhouse')
        );
    }
}
