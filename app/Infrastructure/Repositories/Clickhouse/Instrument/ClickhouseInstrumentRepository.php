<?php

namespace App\Infrastructure\Repositories\Clickhouse\Instrument;

use App\Domain\Instrument\InstrumentRepositoryInterface;
use App\Domain\Instrument\Share\Share;
use App\Infrastructure\Adapters\ClickhouseAdapter;
use Tinderbox\ClickhouseBuilder\Exceptions\Exception;

class ClickhouseInstrumentRepository implements InstrumentRepositoryInterface
{
    public function __construct(
        private readonly ClickhouseAdapter $adapter
    )
    {
    }


    public function saveAll($tableName, array $instruments)
    {
        try {
            $connection = $this->adapter->getConnection();
            $array_instruments = [];
            foreach ($instruments as $instrument) {
                if ($instrument instanceof Share) {
                    $array_instruments[] = $instrument->toArray();
                }
            }
            $connection->insert('shares', $array_instruments);

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function findByUid($tableName, string $uid): Share
    {

    }

    public function getAll($tableName): array
    {
        try {
            $connection = $this->adapter->getConnection();
            $data =  $connection->select('
                SELECT uid, ticker, company_name, sector  FROM ' . $tableName . '
            ');
            dd($data->rows());
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function delete($tableName, string $uid)
    {
        // TODO: Implement delete() method.
    }

    public function deleteAll($tableName)
    {
        // TODO: Implement deleteAll() method.
    }
}
