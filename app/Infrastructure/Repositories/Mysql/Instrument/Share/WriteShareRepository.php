<?php

namespace App\Infrastructure\Repositories\Mysql\Instrument\Share;

use App\Domain\Instrument\Share\Repository\WriteShareRepositoryInterface;
use Illuminate\Support\Facades\DB;

class WriteShareRepository implements WriteShareRepositoryInterface
{

    const array CHECK_FIELD = ['uid'];
    const array UPDATE_FIELD = [
        'company_name',
        'ticker',
        'lot',
        'short_enabled_flag',
        'issue_size',
        'sector',
        'div_yield_flag'
    ];

    public function save(\App\Domain\Instrument\Share\Share $share): bool
    {
        try {
            return DB::table('shares')->insert($share->toArray());
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function saveAll(array $shares): bool
    {
        try {
            if (!empty($shares)) {
                $insertShares = [];
                foreach ($shares as $share) {
                    $insertShares[] = $share->toArray();
                }
                return DB::table('shares')->upsert($insertShares, self::CHECK_FIELD, self::UPDATE_FIELD);
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }
    public function delete(\App\Domain\Instrument\Share\Share $share): void
    {
        try {
            DB::table('share')->where('uid', '=', $share->uid);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function deleteAll()
    {
        try {
            DB::table('shares')->truncate();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

}
