<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

readonly class TradeDirection
{
    public const DIRECTION_BUY = 1;
    public const DIRECTION_SELL = 2;
    /**
     * @param int $direction Направление сделки (1 - покупка, 2 - продажа)
     * @throws InvalidArgumentException Если значение недопустимо
     */
    public function __construct(private int $direction)
    {
        $this->validate($direction);
    }

    /**
     * Возвращает значение направления сделки
     */
    public function toInt(): int
    {
        return $this->direction;
    }

    /**
     * Проверяет, является ли направление покупкой
     */
    public function isBuy(): bool
    {
        return $this->direction === self::DIRECTION_BUY;
    }

    /**
     * Проверяет, является ли направление продажей
     */
    public function isSell(): bool
    {
        return $this->direction === self::DIRECTION_SELL;
    }

    /**
     * Создает объект из целочисленного значения
     *
     * @param int $direction
     * @return self
     * @throws InvalidArgumentException Если значение недопустимо
     */
    public static function fromInt(int $direction): self
    {
        return new self($direction);
    }

    /**
     * Валидация значения направления сделки
     *
     * @param int $direction
     * @throws InvalidArgumentException Если значение недопустимо
     */
    private function validate(int $direction): void
    {
        if (!in_array($direction, [self::DIRECTION_BUY, self::DIRECTION_SELL], true)) {
            throw new InvalidArgumentException("Invalid trade direction: {$direction}. Allowed values are " . implode(', ', [self::DIRECTION_BUY, self::DIRECTION_SELL]));
        }
    }

    /**
     * Сравнивает текущее направление с другим
     *
     * @param TradeDirection $other
     * @return bool
     */
    public function equals(TradeDirection $other): bool
    {
        return $this->direction === $other->toInt();
    }
}
