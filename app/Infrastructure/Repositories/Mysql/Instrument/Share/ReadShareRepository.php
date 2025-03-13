<?php

namespace App\Infrastructure\Repositories\Mysql\Instrument\Share;

use App\Domain\Repositories\Instrument\Share\ReadShareRepositoryInterface;
use App\Domain\Entity\Instrument\Share;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Sector;
use App\Domain\ValueObjects\Volume;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ReadShareRepository implements ReadShareRepositoryInterface
{
    /**
     * Преобразует коллекцию данных в массив объектов Share.
     *
     * @param \Illuminate\Support\Collection $instruments
     * @return array<Share>
     */
    private function extract(\Illuminate\Support\Collection $instruments): array
    {
        $shares = [];
        foreach ($instruments as $instrument) {
            $shares[] = $this->createShareFromData($instrument);
        }
        return $shares;
    }

    /**
     * Создает объект Share из данных базы данных.
     *
     * @param object $data
     * @return Share
     * @throws InvalidArgumentException
     */
    private function createShareFromData(object $data): Share
    {
        try {
            return new Share(
                new InstrumentUid($data->uid),
                $data->company_name,
                $data->ticker,
                (int)$data->lot,
                (bool)$data->short_enabled_flag,
                (int)$data->issue_size,
                new Sector($data->sector),
                (bool)$data->div_yield_flag,
                new Volume($data->volume)
            );
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Invalid data for Share with UID: {$data->uid}", 0, $e);
        }
    }

    public function findByUid(InstrumentUid $uid): ?Share
    {
        $instrument = DB::table('shares')->where('uid', (string)$uid)->first();
        return $instrument ? $this->createShareFromData($instrument) : null;
    }

    /**
     * Возвращает все акции.
     *
     * @return array<Share> Массив объектов Share.
     */
    public function getAll(): array
    {
        $instruments = DB::table('shares')->get();
        return $this->extract($instruments);
    }

    /**
     * Возвращает акции, отфильтрованные по сектору.
     *
     * @param Sector $sector Сектор для фильтрации.
     * @return array<Share> Массив объектов Share.
     */
    public function findBySector(Sector $sector): array
    {
        $instruments = DB::table('shares')->where('sector', (string)$sector)->get();
        return $this->extract($instruments);
    }


}
