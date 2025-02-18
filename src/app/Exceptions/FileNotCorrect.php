<?php

declare(strict_types = 1);

namespace App\Exceptions;

use Exception;

class FileNotCorrect extends Exception
{
    protected $message = 'Data in cvs files is not correct';
}