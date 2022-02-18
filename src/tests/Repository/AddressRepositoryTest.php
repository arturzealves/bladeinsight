<?php

namespace BladeInsight\Tests\Repository;

use BladeInsight\Repository\AddressRepository;
use BladeInsight\FileSystem\CsvReader;
use BladeInsight\FileSystem\CsvWriter;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class AddressRepositoryTest extends TestCase
{
    use ProphecyTrait;

    const CSV_FILE = 'test.csv';
    const CSV_CONTENT = 'Amaral1-1,Gamesa,39.0,-9.04';
    const CSV_CONTENT_ARRAY = ['Amaral1-1','Gamesa', '39.0', '-9.04'];

    private $testSubject;
    private $csvReader;
    private $csvWriter;

    public function setup(): void
    {
        $this->csvReader = $this->prophesize(CsvReader::class);
        $this->csvWriter = $this->prophesize(CsvWriter::class);

        $this->testSubject = new AddressRepository(
            $this->csvReader->reveal(),
            $this->csvWriter->reveal(),
            self::CSV_FILE
        );
    }
    
    public function testFindByIndex()
    {
        $this->csvReader
            ->read(self::CSV_FILE)
            ->shouldBeCalledTimes(2)
            ->willReturn([self::CSV_CONTENT_ARRAY]);

        $this->assertEquals(
            self::CSV_CONTENT_ARRAY,
            $this->testSubject->findByIndex(0)
        );

        $this->assertEquals(
            [],
            $this->testSubject->findByIndex(1)
        );
    }

    public function testAdd()
    {
        $this->csvWriter
            ->append(self::CSV_FILE, self::CSV_CONTENT_ARRAY)
            ->shouldBeCalledTimes(1);

        $this->assertInstanceOf(
            AddressRepository::class,
            call_user_func_array([$this->testSubject, "add"], self::CSV_CONTENT_ARRAY)
        );
    }

    public function testDelete()
    {
        $this->csvReader
            ->read(self::CSV_FILE)
            ->shouldBeCalledTimes(2)
            ->willReturn([self::CSV_CONTENT_ARRAY]);
        
        $this->csvWriter
            ->write(self::CSV_FILE, [])
            ->shouldBeCalledTimes(1);

        $this->assertEquals(
            self::CSV_CONTENT_ARRAY,
            $this->testSubject->delete(self::CSV_CONTENT_ARRAY[0])
        );

        $this->assertEquals(
            [],
            $this->testSubject->delete('not-existing-id')
        );
    }

    public function testGetAll()
    {
        $this->csvReader
            ->read(self::CSV_FILE)
            ->shouldBeCalledTimes(1)
            ->willReturn([self::CSV_CONTENT_ARRAY]);

        $this->assertEquals(
            [self::CSV_CONTENT_ARRAY],
            $this->testSubject->getAll()
        );
    }

    public function testGetLast()
    {
        $this->csvReader
            ->read(self::CSV_FILE)
            ->shouldBeCalledTimes(1)
            ->willReturn([self::CSV_CONTENT_ARRAY]);

        $this->assertEquals(
            self::CSV_CONTENT_ARRAY,
            $this->testSubject->getLast()
        );
    }

    public function testUpdate()
    {
        $expected = [
            self::CSV_CONTENT_ARRAY[0],
            'updatedGamesa',
            '0.93',
            '40.9',
        ];

        $this->csvReader
            ->read(self::CSV_FILE)
            ->shouldBeCalledTimes(1)
            ->willReturn([self::CSV_CONTENT_ARRAY]);
        
        $this->csvWriter
            ->write(self::CSV_FILE, [$expected])
            ->shouldBeCalledTimes(1);

        $this->assertEquals(
            $expected,
            $this->testSubject->update(
                self::CSV_CONTENT_ARRAY[0],
                'updatedGamesa',
                '0.93',
                '40.9',
            )
        );
    }
}
