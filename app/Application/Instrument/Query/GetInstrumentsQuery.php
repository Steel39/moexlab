<?php

namespace App\Application\Instrument\Query;

class GetInstrumentsQuery
{
    public function __construct(public string $tableName, public array $queryParams = [])
    {
    }
}
