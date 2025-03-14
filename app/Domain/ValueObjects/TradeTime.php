<?php

namespace App\Domain\ValueObjects;

use Google\Protobuf\Timestamp;
use InvalidArgumentException;

readonly class TradeTime
{
    /**
     * @param int $timestamp Временная метка в формате Unix-времени (секунды)
     */
    public function __construct(private int $timestamp)
    {
        if ($timestamp <= 0) {
            throw new InvalidArgumentException("Timestamp must be greater than zero. Provided value: {$timestamp}");
        }
    }

    /**
     * Возвращает временную метку в формате Unix-времени (секунды)
     */
    public function getSeconds(): int
    {
        return $this->timestamp;
    }

    /**
     * Преобразует объект в строку в формате ISO 8601
     */
    public function toString(): string
    {
        return gmdate('Y-m-d\TH:i:s\Z', $this->timestamp);
    }

    /**
     * Создает TradeTime из текущего времени
     */
    public static function now(): self
    {
        return new self(time());
    }

    /**
     * Создает TradeTime из строки в формате ISO 8601
     */
    public static function fromString(string $iso8601): self
    {
        $parsedTimestamp = strtotime($iso8601);
        if ($parsedTimestamp === false) {
            throw new InvalidArgumentException("Invalid timestamp string: {$iso8601}");
        }
        return new self($parsedTimestamp);
    }

    /**
     * Создает TradeTime из объекта Timestamp
     */
    public static function fromTimestamp(Timestamp $timestamp): self
    {
        return new self($timestamp->getSeconds());
    }

    /**
     * Сравнивает текущую временную метку с другой
     *
     * @param TradeTime $other Другая временная метка
     * @return bool
     */
    public function equals(TradeTime $other): bool
    {
        return $this->timestamp === $other->getSeconds();
    }
}
