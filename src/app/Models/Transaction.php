<?php

declare(strict_types=1);

namespace App\Models;

class Transaction
{


    public function __construct(
        private string $date,
        private int    $amount,
        private string $check,
        private string $description,
    )
    {
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCheck(): string
    {
        return $this->check;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}