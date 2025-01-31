<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class RouterNotFoundException extends Exception
{
    protected $message = '404 Not Found';
}