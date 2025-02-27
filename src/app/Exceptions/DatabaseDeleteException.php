<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class DatabaseDeleteException extends Exception
{
    protected $message = 'Error when delete row from database';
}