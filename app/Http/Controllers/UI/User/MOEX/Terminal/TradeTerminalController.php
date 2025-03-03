<?php

namespace App\Http\Controllers\UI\User\MOEX\Terminal;

use Inertia\Inertia;
use Inertia\Response;

class TradeTerminalController
{
    public function __invoke(): Response
    {

        return Inertia::render('Guest/Pages/MOEX/TradeTerminal/TradeTerminal');

    }
}
