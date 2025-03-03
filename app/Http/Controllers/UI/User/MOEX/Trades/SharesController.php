<?php

namespace App\Http\Controllers\UI\User\MOEX\Trades;

use App\Application\Market\Trade\DTOs\Market\TotalVolumeTradesDTO;
use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;
use App\Application\Market\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Application\Market\Trade\Queries\GetTradesByTime\Handler\GetTradesByTimeHandler;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SharesController extends Controller
{
    const ONE_HOUR_SECONDS = 3600;

    public function __construct(private readonly GetTradesByTimeHandler $handler,
     )
    {
    }

    public function __invoke()
    {
        $stockData = self::getLastHourTrades();
        return Inertia::render('Guest/Pages/MOEX/TradeTerminal/TradeTerminal', ['stockData' => $stockData]);
    }

    private function getTradesByTime(int $beginTime = null, int $endTime = null): Response
    {

        /*$beginTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($beginTime));
        $endTimeValue = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($endTime));
        $query = new GetTradesByTimeQuery(new TradePeriodTimeDTO($beginTimeValue, $endTimeValue));
        $data = $this->handler->handle($query);
        dd($data);
        */
        return Inertia::render('Guest/Pages/MOEX/Shares');
    }

    private function getLastHourTrades(): array
    {
        $endTime = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp(time()));
        $beginTime = new TradeTimeValue(TradeTimeValue::fromIntToTimestamp(time() - self::ONE_HOUR_SECONDS));
        $query = new GetTradesByTimeQuery(new TradePeriodTimeDTO($beginTime, $endTime));
        $data = $this->handler->handle($query);
        $arrayData = [];
        foreach ($data as $trade) {
            $arrayData[] = TotalVolumeTradesDTO::toArray($trade);
        }
        return $arrayData;
    }

    public function show()
    {

    }
}
