<?php

declare(strict_types=1);

namespace src\Models;

use ValueObjects\Currency;

readonly  class Transaction
{

    private Currency $currency;

    public function __construct(
        private string $date,
        private string $amount,
        private string $check,
        private string $description,
    )
    {
        $this->currency = new Currency($this->amount);
    }

    public function toArray(Transaction $transaction): array
    {
        $amount = $this->currency->formatToInt($this->amount);
        return [
            'date' => $this->date,
            'amount' => $amount,
            'check' => $this->check,
            'description' => $this->description,
            'is_positive' => $this->currency->isPositiveAmount($amount),
        ];

    }


    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }


}