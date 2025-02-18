<?php

namespace App\Models;

use App\Exceptions\FileNotFound;

class CsvFile extends File
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