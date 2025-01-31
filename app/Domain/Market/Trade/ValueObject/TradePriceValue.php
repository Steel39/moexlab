<?php

namespace App\Domain\Market\Trade\ValueObject;

use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;

readonly class TradePriceValue
{
    public function __construct(private readonly Quotation $moneyValue)
    {
    }

    public function getFloatPrice(): float
    {
        try {
            return QuotationHelper::toDecimal($this->moneyValue);
        } catch (ValidateException $e) {
            return $e->getMessage();
        }
    }
}
