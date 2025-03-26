<?php

declare(strict_types=1);

namespace src\Exceptions;


class FileNotFound extends \Exception
{
    protected $message = 'File not found';
}