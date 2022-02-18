<?php

namespace BladeInsight\Controller;

use BladeInsight\FileSystem\CsvReader;
use BladeInsight\FileSystem\CsvWriter;
use BladeInsight\Repository\AddressRepository;

class AddressController
{
    const CSV_FILE = 'turbines.csv';

    protected $repository;

    public function __construct()
    {
        $this->repository = new AddressRepository(
            new CsvReader(),
            new CsvWriter(),
            self::CSV_FILE
        );
    }

    public function executeAction($id): string
    {
        return json_encode($this->repository->findByIndex($id));
    }

    public function addAction(
        string $id, 
        string $name, 
        string $latitude, 
        string $longitude
    ): string {
        $result = $this->repository
            ->add($id, $name, $latitude, $longitude)
            ->getLast();

        return json_encode($result);
    }

    public function listAction(): string
    {
        return json_encode($this->repository->getAll());
    }

    public function updateAction(
        string $id, 
        string $name, 
        string $latitude, 
        string $longitude
    ): string {
        return json_encode($this->repository->update($id, $name, $latitude, $longitude));
    }

    public function deleteAction($id): string
    {
        return json_encode($this->repository->delete($id));
    }
}
