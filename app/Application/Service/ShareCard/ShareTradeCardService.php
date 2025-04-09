<?php

namespace App\Application\Service\ShareCard;

use App\Application\Instrument\Share\DTOs\SharesDTO;
use App\Application\Instrument\Share\Query\GetSharesQuery;
use App\Application\Instrument\Share\Query\Handler\GetSharesQueryHandler;
use App\Application\Market\Trade\DTOs\Market\TradeDTO;
use App\Application\Market\Trade\DTOs\TradePeriodTimeDTO;
use App\Application\Market\Trade\Queries\GetTradesByTime\GetTradesByTimeQuery;
use App\Application\Market\Trade\Queries\GetTradesByTime\Handler\GetTradesByTimeHandler;
use App\Domain\Market\Trade\ValueObject\TradeTimeValue;
use App\Domain\ValueObjects\DifferentPrice;
use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\RelativeVolume;
use App\Domain\ValueObjects\Sector;
use App\Domain\ValueObjects\Volume;
use DateTimeImmutable;

readonly class ShareTradeCardService
{
    public function __construct(
        private GetSharesQueryHandler  $getSharesQueryHandler,
        private GetTradesByTimeHandler $getTradesByTimeHandler,
    )
    {
    }

    /**
     * Основной метод для получения объединенных данных акций и сделок.
     *
     * @param TradePeriodTimeDTO|null $periodTimeDTO Период времени для фильтрации сделок
     * @return array Объединенные данные акций и сделок
     */
    public function getSharesDataCard(TradePeriodTimeDTO $periodTimeDTO = null): array
    {
        // Если период времени не передан, используем значение по умолчанию (текущий день)
        if ($periodTimeDTO === null) {
            $periodTimeDTO = self::getTodayTradingTime();
        }

        // Получаем данные акций и сделок
        $sharesQuery = new GetSharesQuery();
        $tradeQuery = new GetTradesByTimeQuery($periodTimeDTO);

        /** @var SharesDTO[] $shares */
        $shares = ($this->getSharesQueryHandler)($sharesQuery);
        /** @var TradeDTO[] $trades */
        $trades = ($this->getTradesByTimeHandler)($tradeQuery);

        // Объединяем данные акций и сделок

        $sharesData = self::mergeSharesAndTrades($shares, $trades);
        $sharesCard = [];
        foreach ($sharesData as $shareCard) {
            $totalVolume = $shareCard['total_buy_quantity'] + $shareCard['total_sell_quantity'];
            $sharesCard[] = new SharesTradeCardDTO(
                new InstrumentUid($shareCard['uid']),
                $shareCard['ticker'],
                $shareCard['company_name'],
                $shareCard['sector'],
                new Volume($shareCard['total_buy_quantity']),
                new Volume($shareCard['total_sell_quantity']),
                new DifferentPrice(new Price($shareCard['first_trade_price']), new Price($shareCard['last_trade_price'])),
                new RelativeVolume(new Volume($shareCard['volume']), new  Volume($totalVolume)),
                new Price($shareCard['avg_buy_price']),
                new Price($shareCard['avg_sell_price']),

            );
        }
        return $sharesCard;
    }

    /**
     * Возвращает временной диапазон для текущего торгового дня.
     *
     * @return TradePeriodTimeDTO
     */
    public static function getTodayTradingTime(): TradePeriodTimeDTO
    {
        $end = new DateTimeImmutable('now');
        $begin = $end->modify('today midnight');
        return new TradePeriodTimeDTO(
            new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($begin->getTimestamp())),
            new TradeTimeValue(TradeTimeValue::fromIntToTimestamp($end->getTimestamp()))
        );
    }

    /**
     * Объединяет данные акций и сделок по полю uid.
     *
     * @param SharesDTO[] $shares Массив DTO акций
     * @param TradeDTO[] $trades Массив DTO сделок
     * @return array Объединенные данные
     */
    private static function mergeSharesAndTrades(array $shares, array $trades): array
    {
        // Создаем ассоциативный массив акций по uid
        $sharesByUid = [];
        foreach ($shares as $share) {
            $sharesByUid[$share->uid->getValue()] = $share->toArray();
        }

        // Объединяем данные
        $result = [];
        foreach ($trades as $trade) {
            $tradeData = $trade->toArray($trade);
            $uid = $tradeData['uid'];

            if (isset($sharesByUid[$uid])) {
                // Добавляем данные из акций в сделки
                $result[] = array_merge($tradeData, $sharesByUid[$uid]);
            } else {
                // Если нет соответствия, добавляем только данные сделки
                $result[] = $tradeData;
            }
        }

        return $result;
    }
}
