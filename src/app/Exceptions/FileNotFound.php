<?php

declare(strict_types=1);

namespace App\Exceptions;


class FileNotFound extends \Exception
{
    protected $message = 'File not found';
}