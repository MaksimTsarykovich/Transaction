<?php

declare(strict_types = 1);

namespace src\Exceptions;

use Exception;

class RouterNotFoundException extends Exception
{
    protected $message = '404 Not Found';
}