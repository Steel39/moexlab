<?php

namespace App\Http\Controllers;

use App\Domain\Instrument\InstrumentRepositoryInterface;
use App\Infrastructure\Repositories\TInvestApi\Instrument\Shares\TInvestSharesRepository;
use Inertia\Inertia;

class TestController
{
    public function __construct(

    )
    {
    }

    public function __invoke()
    {
        return Inertia::render('Guest/MOEX/TradeGraphics/Index');
    }
}
