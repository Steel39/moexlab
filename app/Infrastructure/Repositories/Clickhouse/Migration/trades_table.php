<?php

use App\Infrastructure\Adapters\ClickhouseAdapter;

return new readonly class
{
    public function __construct(private ClickhouseAdapter $adapter)
    {

    }

    public function run(): void
    {
        $db = $this->adapter->getConnection();
        $db->write('
        CREATE TABLE IF NOT EXISTS example_table (
                id Int64,
                Uid String,
                direction INT,
                price Float,
                quantity INT,
                time DATETIME

            ) ENGINE = MergeTree()
            ORDER BY time
            ');
    }
    public function drop(): void
    {

    }
};
