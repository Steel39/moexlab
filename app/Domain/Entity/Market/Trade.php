<?php

namespace App\Domain\Entity\Market;

use App\Domain\ValueObjects\InstrumentUid;
use App\Domain\ValueObjects\Price;
use App\Domain\ValueObjects\TradeDirection;
use App\Domain\ValueObjects\TradeTime;
use App\Domain\ValueObjects\Volume;

readonly class Trade
{
    public function __construct(
        private readonly InstrumentUid $uid,
        private readonly TradeDirection $direction,
        private readonly Price $price,
        private readonly Volume $volume,
        private readonly TradeTime $tradeTime
    ) {
        // Конструктор уже не требует дополнительной логики, так как все проверки выполняются в Value Objects.
    }

    /**
     * Возвращает уникальный идентификатор инструмента
     */
    public function getUid(): InstrumentUid
    {
        return $this->uid;
    }

    /**
     * Возвращает направление сделки
     */
    public function getDirection(): TradeDirection
    {
        return $this->direction;
    }

    /**
     * Возвращает цену сделки
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * Возвращает объем сделки
     */
    public function getVolume(): Volume
    {
        return $this->volume;
    }

    /**
     * Возвращает временную метку сделки
     */
    public function getTradeTime(): TradeTime
    {
        return $this->tradeTime;
    }

    /**
     * Преобразует объект в массив (например, для сериализации)
     */
    public function toArray(): array
    {
        return [
            'uid' => $this->uid->toString(),
            'direction' => $this->direction->toInt(),
            'price' => $this->price->getFloatPrice(),
            'volume' => $this->volume->getValue(),
            'trade_time' => $this->tradeTime->toString(),
        ];
    }

    /**
     * Создает объект Trade из массива данных
     *
     * @param array $data Массив данных для создания объекта
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            new InstrumentUid($data['uid']),
            TradeDirection::fromInt($data['direction']),
            new Price($data['price']),
            new Volume($data['volume']),
            TradeTime::fromString($data['trade_time'])
        );
    }
}
