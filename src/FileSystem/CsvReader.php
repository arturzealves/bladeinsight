<?php

namespace BladeInsight\FileSystem;

use BladeInsight\Exception\FileNotFoundException;

class CsvReader
{
    public function read($filePath): array
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException($filePath);
        }

        $result = [];
        $file = fopen($filePath, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            $result[] = $line;
        }
        fclose($file);

        return $result;
    }
}
