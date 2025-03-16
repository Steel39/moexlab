<?php

namespace App\Http\Controllers;

use App\Application\Service\ShareCard\ShareTradeCardService;
use Inertia\Inertia;

class TestController
{
    public function __construct(
        private readonly ShareTradeCardService $boardingCardService
    )
    {
    }

    public function __invoke()
    {
        $data =  ($this->boardingCardService)($this->boardingCardService::getTodayTradingTime());
        dd($data);
        return Inertia::render('Guest/MOEX/TradeGraphics/Index');
    }
}
