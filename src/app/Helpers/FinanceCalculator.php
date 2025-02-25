<?php

declare(strict_types=1);

namespace App\Helpers;

class FinanceCalculator
{
    private array $income = [];
    private array $expense = [];
    private int $decimal;

    public function calculate(Currency $currency): void
    {
        $this->setDecimal($currency);

        $amount = $currency->getIntAmount();
        Utils::dump($this->decimal);

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
            'total' => $total,
            'income' => $totalIncome,
            'expense' => $totalExpense,
        ];
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