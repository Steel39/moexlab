<?php

namespace App\Domain\Market\Trade\ValueObject;


use PHPUnit\Util\Json;

class TradeUidValue
{
    public function __construct(
        private readonly string $uid
    )
    {
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getJson(): false|string
    {
        return json_encode([
            'uid' => $this->uid,
        ]);
    }
}
