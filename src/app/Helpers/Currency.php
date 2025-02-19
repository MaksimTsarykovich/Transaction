<?php

namespace App\Helpers;

class Currency
{
    protected int $decimal;
    protected const OFFSET = 1;
    protected const BASE = 10;

    public function __construct(
        protected string $amount,
        protected string $currency = 'USD',
    )
    {
    }

    public function formatToInt(string $amount, string $currencySymbol = '$'): int
    {
        $amount = str_replace([$currencySymbol, ' ',], '', $amount);

        $this->decimal = mb_strlen($amount) - strrpos($amount, '.') - static::OFFSET;
        $amount = $this->normalizeDecimalSeparator($amount);
        $amount *= static::BASE ** ($this->decimal);

        return $amount;
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

    public function isPositiveAmount(int $amount): bool
    {
        return $amount > 0;
    }

}