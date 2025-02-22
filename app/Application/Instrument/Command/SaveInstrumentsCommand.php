<?php

namespace App\Application\Instrument\Command;

readonly class SaveInstrumentsCommand
{
    public function __construct(public string $tableName, public array $instruments)
    {
    }
}
