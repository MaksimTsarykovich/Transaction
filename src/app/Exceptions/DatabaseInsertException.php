<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class DatabaseInsertException extends Exception
{
    protected $message = 'Error when inserting into database';
}