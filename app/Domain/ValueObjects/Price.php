<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;

readonly class Price
{
    private float $value;

    /**
     * @param MoneyValue|Quotation|float|string $price Значение цены
     * @throws InvalidArgumentException Если цена недопустима
     */
    public function __construct(private mixed $price)
    {
        $this->validateAndSetPrice($price);
    }

    /**
     * Возвращает значение цены в формате float
     */
    public function getFloatPrice(): float
    {
        return $this->value;
    }

    /**
     * Преобразует объект в строку
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    /**
     * Проверяет корректность значения цены и преобразует его в float
     *
     * @param MoneyValue|Quotation|float|string $price
     * @throws InvalidArgumentException Если цена недопустима
     */
    private function validateAndSetPrice(mixed $price): void
    {
        if ($price instanceof Quotation) {
            try {
                // Используем QuotationHelper для преобразования Quotation в float
                $this->value = QuotationHelper::toDecimal($price);
            } catch (ValidateException $e) {
                throw new InvalidArgumentException("Failed to convert Quotation to price: " . $e->getMessage());
            }
        } elseif ($price instanceof MoneyValue) {
            try {
                // Для MoneyValue используем units и nano для расчета значения
                $units = $price->getUnits();
                $nano = $price->getNano();
                $this->value = $units + ($nano / 1_000_000_000); // Переводим nano в дробную часть
            } catch (\Throwable $e) {
                throw new InvalidArgumentException("Failed to convert MoneyValue to price: " . $e->getMessage());
            }
        } elseif (is_float($price)) {
            $this->value = $price;
        } elseif (is_string($price)) {
            if (!is_numeric($price)) {
                throw new InvalidArgumentException("Invalid string price value: {$price}");
            }
            $this->value = (float)$price;
        } else {
            throw new InvalidArgumentException("Unsupported price type: " . gettype($price));
        }

        // Дополнительная проверка на корректность значения
        if ($this->value <= 0) {
            throw new InvalidArgumentException("Price must be greater than zero. Provided value: {$this->value}");
        }
    }
}
