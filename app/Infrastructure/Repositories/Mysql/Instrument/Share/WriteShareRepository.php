<?php

namespace App\Infrastructure\Repositories\Mysql\Instrument\Share;

use App\Domain\Entity\Instrument\Share;
use App\Domain\Repositories\Instrument\Share\WriteShareRepositoryInterface;
use App\Domain\ValueObjects\InstrumentUid;
use Illuminate\Support\Facades\DB;
use PDOException;

class WriteShareRepository implements WriteShareRepositoryInterface
{
    const array CHECK_FIELDS = ['uid'];
    const array UPDATE_FIELDS = [
        'company_name',
        'ticker',
        'lot',
        'short_enabled_flag',
        'issue_size',
        'sector',
        'div_yield_flag',
        'volume'
    ];

    /**
     * Сохраняет одну акцию в хранилище.
     *
     * @param Share $share
     * @return void
     * @throws PDOException
     */
    public function save(Share $share): void
    {
        try {
            DB::table('shares')->insert($this->toArray($share));
        } catch (PDOException $e) {
            throw new PDOException("Failed to save share with UID: {$share->getUid()}", 0, $e);
        }
    }

    /**
     * Сохраняет несколько акций в хранилище.
     *
     * @param Share[] $shares
     * @return bool
     * @throws PDOException
     */
    public function saveAll(array $shares): void
    {
        try {
            $insertShares = array_map([$this, 'toArray'], $shares);
            DB::table('shares')->upsert($insertShares, self::CHECK_FIELDS, self::UPDATE_FIELDS);
        } catch (PDOException $e) {
            throw new PDOException("Failed to save multiple shares", 0, $e);
        }
    }

    /**
     * Удаляет одну акцию из хранилища.
     *
     * @param Share $share
     * @return void
     * @throws PDOException
     */
    public function delete(Share $share): void
    {
        try {
            DB::table('shares')->where('uid', (string)$share->getUid())->delete();
        } catch (PDOException $e) {
            throw new PDOException("Failed to delete share with UID: {$share->getUid()}", 0, $e);
        }
    }

    /**
     * Удаляет все акции из хранилища.
     *
     * @return void
     * @throws PDOException
     */
    public function deleteAll(): void
    {
        try {
            DB::table('shares')->delete();
        } catch (PDOException $e) {
            throw new PDOException("Failed to truncate shares table", 0, $e);
        }
    }

    /**
     * Удаляет акцию по уникальному идентификатору.
     *
     * @param InstrumentUid|string $uid
     * @return void
     */
    public function deleteByUid(InstrumentUid|string $uid): void
    {
        try {
            DB::table('shares')->where('uid', (string)$uid)->delete();
        } catch (PDOException $e) {
            throw new PDOException("Failed to delete share with UID: {$uid}", 0, $e);
        }
    }

    /**
     * Преобразует объект Share в массив для сохранения в базу данных.
     *
     * @param Share $share
     * @return array
     */
    private function toArray(Share $share): array
    {
        return [
            'uid' => (string)$share->getUid()->toString(),
            'company_name' => $share->getCompanyName(),
            'ticker' => $share->getTicker(),
            'lot' => $share->getLot(),
            'short_enabled_flag' => $share->isShortSellingAllowed(),
            'issue_size' => $share->getIssueSize(),
            'sector' => (string)$share->getSector()->getSector(),
            'div_yield_flag' => $share->hasDividendYield(),
            'volume' => $share->getVolume()
        ];
    }

    /**
     * Обновляет недельный объем для заданной акции.
     *
     * @param InstrumentUid $instrumentUid Идентификатор инструмента.
     * @param int $weeklyVolume Недельный объем.
     */
    public function bulkUpdateWeeklyVolumes(array $updates): void
    {
        DB::transaction(function () use ($updates) {
            // Выполняем массовое обновление
            foreach ($updates as $update) {
                DB::table('shares')
                    ->where('uid', $update['uid'])
                    ->update([
                        'volume' => $update['volume'],
                    ]);
            }
        });
    }
}
