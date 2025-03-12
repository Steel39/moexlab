<?php

namespace App\Domain\Repositories\Market\Candle;

use App\Domain\ValueObjects\InstrumentUid;
use Google\Protobuf\Timestamp;

interface GetCandleByIntervalInterface
{
    public function getCandleByInterval(InstrumentUid $uid, Timestamp $start, Timestamp $end);
}
