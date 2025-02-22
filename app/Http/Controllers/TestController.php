<?php

namespace App\Http\Controllers;

use App\Domain\Instrument\InstrumentRepositoryInterface;
use App\Infrastructure\Repositories\TInvestApi\Instrument\Shares\TInvestSharesRepository;

class TestController
{
    public function __construct(
        private readonly InstrumentRepositoryInterface $rep,
        private readonly TInvestSharesRepository       $test
    )
    {
    }

    public function __invoke()
    {
        $shares = $this->test->getShares();
        $check = $this->rep->saveAll($shares);
        dd($check);
    }
}
