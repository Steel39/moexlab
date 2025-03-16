<?php

namespace App\Http\Controllers\UI\User\MOEX\Trades;

use App\Application\Market\Trade\DTOs\Market\TotalVolumeTradesDTO;
use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;
use App\Application\Market\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Application\Market\Trade\Queries\GetTradesByTime\Handler\GetTradesByTimeHandler;
use App\Application\Service\ShareCard\ShareTradeCardService;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SharesController extends Controller
{

    public function __construct(private readonly ShareTradeCardService $tradeCardService)
    {
    }

    public function __invoke()
    {
        $stockData = self::getLastTrades();
        return Inertia::render('Guest/MOEX/TradeTerminal/TradeTerminal', ['stockData' => $stockData]);
    }

    private function getTradesByTime(int $beginTime = null, int $endTime = null): Response
    {

        /*$beginTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($beginTime));
        $endTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($endTime));
        $query = new GetTradesByTimeQuery(new TradePeriodTimeDTO($beginTimeValue, $endTimeValue));
        $data = $this->handler->handle($query);
        dd($data);
        */
        return Inertia::render('Guest/Pages/MOEX/Share');
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

    public function show()
    {

    }
}
