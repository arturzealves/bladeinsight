<?php

namespace BladeInsight\FileSystem;

use BladeInsight\Exception\FileNotFoundException;

class CsvWriter
{
    public function write(string $filePath, array $data): void
    {
        $file = fopen($filePath, 'w');
        if (is_array(current($data))) {
            foreach($data as $element) {
                fputcsv($file, $element, ',', '"');
            }
            
            fclose($file);

            return;
        }
    
        fputcsv($file, $data, ',', '"');
        fclose($file);
    }

    public function append(string $filePath, array $data): void
    {
        $file = fopen($filePath, 'a+');
        fputcsv($file, $data, ',', '"');
        fclose($file);
    }
}
