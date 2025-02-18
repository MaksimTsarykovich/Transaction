<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class TransactionsNotFound extends Exception
{
    protected $message = 'Transactions not found in the database ';
}