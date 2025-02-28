<?php

namespace App\Http\Controllers\UI\User\MOEX\Trades;

use App\Application\Trade\DTOs\Market\TradeDTO;
use App\Application\Trade\DTOs\TradePeriodTimeDTO;
use App\Application\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Application\Trade\Queries\GetTradesByTime\Handler\GetTradesByTimeHandler;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use PHPUnit\Util\Json;

class SharesController extends Controller
{
    const ONE_HOUR_SECONDS = 3600;

    public function __construct(private readonly GetTradesByTimeHandler $handler)
    {
    }

    public function __invoke()
    {
        $stockData = [
            'stockData' => [
                'ticker' => 'AAPL',
                'purchaseVolume' => 26000,
                'saleVolume' => 22000,
                'priceChange' => '+2.5%',
                'relativeVolume' => 0.24
            ],
            [
                'ticker' => 'FB',
                'purchaseVolume' => 11000,
                'saleVolume' => 9000,
                'priceChange' => '+2.5%',
                'relativeVolume' => 0.56
            ],
            [
                'ticker' => 'GAZP',
                'purchaseVolume' => 32000,
                'saleVolume' => 16000,
                'priceChange' => '+2.5%',
                'relativeVolume' => 0.65
            ],


        ];
        return Inertia::render('Guest/Pages/MOEX/TradeTerminal/TradeTerminal', ['stockData' => $stockData]);
    }

    public function getTradesByTime(int $beginTime = null, int $endTime = null): Response
    {

        /*$beginTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($beginTime));
        $endTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($endTime));
        $query = new GetTradesByTimeQuery(new TradePeriodTimeDTO($beginTimeValue, $endTimeValue));
        $data = $this->handler->handle($query);
        dd($data);
        */
        return Inertia::render('Guest/Pages/MOEX/Shares');
    }

    public function getLastHourTrades(): Response
    {
        $endTime = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp(time()));
        $beginTime = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp(time() - self::ONE_HOUR_SECONDS));
        $query = new GetTradesByTimeQuery(new TradePeriodTimeDTO($beginTime, $endTime));
        $data = $this->handler->handle($query);
        $arrayData = [];
        foreach ($data as $trade) {
            $arrayData[] = TradeDTO::toArray($trade);
        }
        return Inertia::render('Guest/Pages/MOEX/Shares', ['tradeArray' => $arrayData]);

    }

    public function show()
    {

    }
}
