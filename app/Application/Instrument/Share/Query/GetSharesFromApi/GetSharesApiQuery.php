<?php

namespace App\Application\Instrument\Share\Query\GetSharesFromApi;

class GetSharesApiQuery
{
    public function __construct(private readonly array $filters = [])
    {

    }

    public function getFilter(): array
    {
        return $this->filters;
    }
}
