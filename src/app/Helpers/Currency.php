<?php

namespace App\Helpers;

readonly class Currency
{
    protected int $decimal;
    protected const  OFFSET = 1;
    protected const  BASE = 10;

    public function __construct(
        protected string $amount,
        protected string $currency = 'USD',
    )
    {
        $this->decimal = mb_strlen($amount) - strrpos($amount, '.') - static::OFFSET;
    }

    public function formatToInt(string $amount, string $currencySymbol = '$'): int
    {
        $amount = str_replace([$currencySymbol, ' ',], '', $amount);

        $amount = $this->normalizeDecimalSeparator($amount);
        $amount *= static::BASE ** ($this->decimal);

        return $amount;
    }

    public function formatToCurrency(int $amount, string $currencySymbol = '$'): string
    {
        (float)$amount /= static::BASE ** ($this->decimal);
        if ($amount < 0) {
            return '-' . $currencySymbol . number_format(abs($amount),
                    $this->decimal, '.', ',');
        }
        return $currencySymbol . number_format($amount,
                $this->decimal, '.', ',');
    }

    private function normalizeDecimalSeparator(string $amount): string
    {
        $lastDot = strrpos($amount, '.');
        $lastComma = strrpos($amount, ',');

        if ($lastDot > $lastComma) {
            $amount = str_replace(',', '', $amount);
        } else {
            $amount = str_replace('.', '', $amount);
            $amount = str_replace(',', '.', $amount);
        }
        return $amount;
    }

    public function isPositiveAmount(int $amount): int
    {
        return $amount > 0;
    }

}