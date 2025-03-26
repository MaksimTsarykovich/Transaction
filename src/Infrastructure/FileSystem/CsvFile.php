<?php

namespace Infrastructure\FileSystem;

use src\Exceptions\FileNotFound;
use src\Models\File;

readonly class CsvFile extends File
{
    /**
     * @throws FileNotFound
     */
    public function readAsArray(): array
    {
        $content = $this->read();
        $lines = explode("\n", $content);
        $data = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                $data[] = str_getcsv($line);
            }
        }
        return $data;
    }
}