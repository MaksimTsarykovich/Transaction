<?php

declare(strict_types = 1);

namespace src\Exceptions;

use Exception;

class ViewNotFoundException extends Exception
{
    protected $message = 'View not found';
}