<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\DateIsIncorrectFormat;
use App\Helpers\Currency;
use App\Helpers\Utils;

readonly  class Transaction
{


    public function __construct(
        private string $date,
        private string $amount,
        private string $check,
        private string $description,
    )
    {
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    public function toArray ():array
    {
        $currency = new Currency($transaction->getAmount());
        $amount = $currency->formatToInt($transaction->getAmount());
        $this->financeCalculator->calculate($amount);
        Utils::dump($transaction);
        return [
            'date' => $this->formatDate($this->date),
            'amount' => $currency->formatToInt($this->amount),
            'check' => $this->check,
            'description' => $this->description,
            'is_positive' => $currency->isPositiveAmount($amount),
        ];

    }
    private function formatAmount(Transaction $transaction): array{
        $currency = new Currency($transaction->getAmount());
        $amount = $currency->formatToInt($transaction->getAmount());
        $this->financeCalculator->calculate($amount);

        return $trasactions;
    }

    private function formatDate(string $date): string
    {
        $date = DateTime::createFromFormat('m/d/Y', $date);
        if (!$date) {
            throw new DateIsIncorrectFormat();
        }
        return $date->format('Y-m-d');
    }

}