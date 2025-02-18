<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class CalculationException extends Exception
{
    protected $message = 'Error in calculating the amount';
}