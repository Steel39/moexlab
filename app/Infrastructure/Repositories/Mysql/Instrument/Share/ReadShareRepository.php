<?php

namespace App\Infrastructure\Repositories\Mysql\Instrument\Share;

use App\Domain\Instrument\Share\Repository\ReadShareRepositoryInterface;
use App\Domain\Instrument\Share\Share;
use Illuminate\Support\Facades\DB;

class ReadShareRepository implements ReadShareRepositoryInterface
{

    public function findByUid(string $uid): Share
    {
        $instrument = DB::table('shares')->where('uid', $uid)->first();
        return new Share(
            $instrument->getUid(),
            $instrument->getName(),
            $instrument->getTicker(),
            $instrument->getLot(),
            $instrument->getShortEnabledFlag(),
            $instrument->getIssueSize(),
            $instrument->getSector(),
            $instrument->getDivYieldFlag(),
        );

    }

    public function getAll(): array
    {
        $shares = [];
        $instruments = DB::table('shares')->get();
        foreach ($instruments as $instrument) {
            $shares[] = new Share(
                $instrument->getUid(),
                $instrument->getName(),
                $instrument->getTicker(),
                $instrument->getLot(),
                $instrument->getShortEnabledFlag(),
                $instrument->getIssueSize(),
                $instrument->getSector(),
                $instrument->getDivYieldFlag(),
            );
        }
        return $shares;
    }
}
