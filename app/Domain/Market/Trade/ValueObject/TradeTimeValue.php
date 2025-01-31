<?php

namespace App\Domain\Market\Trade\ValueObject;

use Google\Protobuf\Timestamp;

class TradeTimeValue
{
    public function __construct(private readonly Timestamp $timestamp)
    {
    }

    public function getTimestamp(): Timestamp
    {
        return $this->timestamp;
    }

    public function toString(): string
    {
        return date('Y-m-d H:i:s', $this->timestamp->getSeconds());
    }
    public function getNanos(): int
    {
        return $this->timestamp->getNanos();
    }

    public function getSeconds(): int
    {
        return $this->timestamp->getSeconds();
    }

    public function getMicroTime(): int
    {
        return $this->getSeconds() . $this->getNanos();
    }

    public static function fromIntToTimestamp(int $time): Timestamp
    {
        return new Timestamp($time);
    }
}
