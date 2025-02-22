<?php

namespace App\Domain\Market\Trade\ValueObject;

use InvalidArgumentException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;

readonly class TradePriceValue
{
    public MoneyValue $value;
    public function __construct(private mixed $moneyValue)
    {

    }

    public function getFloatPrice(): float
    {
        if ($this->moneyValue instanceof Quotation) {
            try {
                return QuotationHelper::toDecimal($this->moneyValue);
            } catch (ValidateException $e) {
                return $e->getMessage();
            }
        }
        if (is_float($this->moneyValue)) {
            return $this->moneyValue;
        }
        if (is_string( $this->moneyValue)) {
            return floatval($this->moneyValue);
        }
        return $this->moneyValue;
    }
}
