<?php

namespace App\Http\Controllers\UI\User\MOEX\Trades;

use App\Application\Service\ShareCard\ShareTradeCardService;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SharesController extends Controller
{

    public function __construct(private readonly ShareTradeCardService $tradeCardService)
    {
    }

    public function __invoke(): Response
    {
        $stockData = self::getLastTrades();
        return Inertia::render('Guest/MOEX/TradeTerminal/TradeTerminal', ['stockData' => $stockData]);
    }

    private function getLastTrades(): array
    {
        $sharesCardsArray = [];
        $sharesCardsDTO = $this->tradeCardService->getSharesDataCard();
        foreach ($sharesCardsDTO as $shareCard) {
            $sharesCardsArray[] = $shareCard->toArray();
        }
        return $sharesCardsArray;
    }

}
