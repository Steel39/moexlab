<?php

namespace App\Http\Controllers\UI\User\MOEX;

use App\Application\Trade\Queries\GetTradesByTimeQuery;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Http\Controllers\Controller;
use App\Infrastructure\Repositories\Clickhouse\Market\ClickHouseTradeRepository;
use App\Infrastructure\Repositories\Mysql\Market\TradeRepository;
use Google\Protobuf\Timestamp;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SharesController extends Controller
{
    public function __invoke(int $beginTime, int $endTime): Response
    {
        $beginTimeValue = TradeTimeValue::fromIntToTimestamp($beginTime);
        $query = new GetTradesByTimeQuery($beginTime, $endTime);
        return Inertia::render('Guest/Pages/MOEX/Shares');
    }
}
