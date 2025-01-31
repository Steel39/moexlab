<?php

namespace App\Infrastructure\Adapters;

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;

final class TClientAdapter
{
    public function getClientFactory(): TinkoffClientsFactory
    {
        return TinkoffClientsFactory::create(config('services.t_invest.token'));
    }

}
