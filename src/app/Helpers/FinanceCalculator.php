<?php

declare(strict_types=1);

namespace App\Helpers;

class FinanceCalculator
{
    const BASE = 10;
    private array $income = [];
    private array $expense = [];
    private int $decimal;

    public function calculate(Currency $currency): void
    {
        $this->setDecimal($currency);

        $amount = $currency->getIntAmount();

        if ($amount > 0) {
            $this->income[] = $amount;
        } elseif ($amount < 0) {
            $this->expense[] = $amount;
        }
    }

    public function getTotal(): array
    {
        $totalIncome = array_sum($this->income);
        $totalExpense = array_sum($this->expense);
        $total = $totalIncome + $totalExpense;
        return [
            'total' => $this->formatToCurrency($total),
            'income' => $this->formatToCurrency($totalIncome),
            'expense' => $this->formatToCurrency($totalExpense),
        ];
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


    private function setDecimal(Currency $currency): void
    {
        if (!isset($this->decimal)) {
            $this->decimal = $currency->getDecimal();
        }
        if ($this->decimal < $currency->getDecimal()) {
            $this->decimal = $currency->getDecimal();
        }
    }
}