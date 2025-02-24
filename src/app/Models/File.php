<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\FileNotFound;

readonly class File
{
    protected string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function exists(): bool
    {
        return file_exists($this->filePath);
    }

    public function read(): string
    {
        if(!$this->exists()){
            throw new FileNotFound();
        }
        return file_get_contents($this->filePath);
    }

}