<?php

declare(strict_types = 1);

namespace src\Exceptions;

use Exception;

class DatabaseCompareRowException extends Exception
{
    protected $message = 'Error when comparing values that are inserted into the database and that already exist in the database';
}