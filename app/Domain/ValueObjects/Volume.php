<?php

namespace App\Domain\ValueObjects;

final readonly class Volume
{
    public function __construct(
        private int $value
    ) {
        if ($value < 0) {
            throw new \InvalidArgumentException("Volume cannot be negative.");
        }
        if (empty($value)){
            $value = 0;
        }
    }

    /**
     * Возвращает значение объема.
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Представляет объем в виде строки.
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }
}
