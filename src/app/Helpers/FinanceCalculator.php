<?php

declare(strict_types=1);

namespace App\Helpers;

class FinanceCalculator
{
    private array $income = [];
    private array $expense = [];

    public function calculate(int $amount): void
    {
        if ($amount > 0) {
            $this->income[] = $amount;
        } elseif ($amount < 0) {
            $this->expense[] = $amount;
        }
    }

    public function getTotal(): array{
        $totalIncome = array_sum($this->income);
        $totalExpense = array_sum($this->expense);
        $total = $totalIncome + $totalExpense;
        return [
            'total' => $total,
            'income' => $totalIncome,
            'expense' => $totalExpense,
        ];
    }
}