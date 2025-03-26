<?php

declare(strict_types = 1);

namespace src\Exceptions;

use Exception;

class DateIsIncorrectFormat extends Exception
{
    protected $message = 'Date in cvs file has incorrect format';
}