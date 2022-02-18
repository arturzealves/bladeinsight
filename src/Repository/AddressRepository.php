<?php
namespace BladeInsight\Repository;

use BladeInsight\FileSystem\CsvReader;
use BladeInsight\FileSystem\CsvWriter;

class AddressRepository
{
    protected $addresses = [];
    protected $filePath;
    protected $csvReader;
    protected $csvWriter;

    public function __construct(
        CsvReader $csvReader, 
        CsvWriter $csvWriter, 
        string $filePath
    ) {
        $this->filePath = $filePath;
        $this->csvReader = $csvReader;
        $this->csvWriter = $csvWriter;
    }

    public function findByIndex($index): array
    {
        $this->load();

        if (!isset($this->addresses[$index])) {
            return [];
        }
        
        return $this->addresses[$index];
    }

    public function add(
        string $id, 
        string $name, 
        string $latitude, 
        string $longitude
    ): self {
        $this->csvWriter->append($this->filePath, [ $id, $name, $latitude, $longitude ]);

        return $this;
    }

    public function delete($id): array
    {
        $this->load();

        $resultIndex = null;
        foreach ($this->addresses as $index => $address) {
            if ($address[0] === $id) {
                $resultIndex = $index;
                break;
            }
        }

        if ($resultIndex === null) {
            return [];
        }

        $result = $this->addresses[$resultIndex];
        unset($this->addresses[$resultIndex]);

        $this->save($this->addresses);

        return $result;
    }

    public function getAll(): array
    {
        $this->load();

        return $this->addresses;
    }
    
    public function getLast(): array
    {
        $this->load();
        end($this->addresses);

        return current($this->addresses);
    }

    public function update(
        string $id, 
        string $name, 
        string $latitude, 
        string $longitude
    ): array {
        $this->load();

        $resultIndex = null;
        foreach ($this->addresses as $index => $address) {
            if ($address[0] === $id) {
                $resultIndex = $index;

                $this->addresses[$index] = [
                    $id,
                    $name,
                    $latitude,
                    $longitude
                ];
            }
        }

        $this->save($this->addresses);

        return $this->addresses[$resultIndex];
    }

    protected function load(): void
    {
        $this->addresses = $this->csvReader->read($this->filePath);
    }

    protected function save(array $data): void
    {
        $this->csvWriter->write($this->filePath, $data);
    }
}
