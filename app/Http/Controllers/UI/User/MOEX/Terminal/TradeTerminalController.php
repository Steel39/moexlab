<?php

namespace App\Http\Controllers\UI\User\MOEX\Terminal;

use App\Application\Instrument\Query\GetInstrumentsQuery;
use App\Application\Instrument\Query\Handler\GetInstrumentsQueryHandler;
use Inertia\Inertia;
use Inertia\Response;

class TradeTerminalController
{

    public function __construct(
        private readonly GetInstrumentsQueryHandler $handler
    )
    {

    }

    public function __invoke(): Response
    {
        $query = new Get();
        $instrumentData = ($this->handler)($query);
        return Inertia::render('Guest/Pages/MOEX/TradeTerminal', $instrumentData);
    }
}
