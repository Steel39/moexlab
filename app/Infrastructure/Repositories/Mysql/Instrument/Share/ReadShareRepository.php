<?php

namespace App\Infrastructure\Repositories\Mysql\Instrument\Share;

use App\Domain\Repositories\Share\Repository\ReadShareRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReadShareRepository implements ReadShareRepositoryInterface
{

    public function findByUid(string $uid): \App\Domain\Repositories\Share\Share
    {
        $instrument = DB::table('shares')->where('uid', $uid)->first();
        return new \App\Domain\Repositories\Share\Share(
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
            $shares[] = new \App\Domain\Repositories\Share\Share(
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
