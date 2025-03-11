<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class InstrumentUid
{
    private string $value;

    /**
     * Конструктор с валидацией формата UUID.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!self::isValidUuid($value)) {
            throw new InvalidArgumentException('Invalid UUID format.');
        }

        $this->value = $value;
    }

    /**
     * Возвращает значение UUID.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Проверяет равенство двух объектов InstrumentUid.
     *
     * @param InstrumentUid $other
     * @return bool
     */
    public function equals(InstrumentUid $other): bool
    {
        return $this->value === $other->getValue();
    }

    /**
     * Валидация формата UUID.
     *
     * @param string $uuid
     * @return bool
     */
    private static function isValidUuid(string $uuid): bool
    {
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $uuid) === 1;
    }

    /**
     * Преобразует объект в строку.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
