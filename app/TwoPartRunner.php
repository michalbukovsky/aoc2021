<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Outputter;
use ReflectionClass;

abstract class TwoPartRunner implements IRunner
{
    protected const TEST_DATA_FILE_1 = 'test1.txt';
    protected const TEST_DATA_FILE_2 = 'test2.txt';
    protected const TEST_DATA_FILE_DEFAULT = 'test.txt';
    protected const DATA_FILE = 'data.txt';


    public function run(int $part): void
    {
        $this->validateDayFolder($part);

        if (!in_array($part, [1, 2], true)) {
            Outputter::errorFatal("Invalid part '$part'.");
        }

        $this->validateTestResult($part);

        if ($part === 1) {
            $result = $this->runPart1($this->getInput(self::DATA_FILE));
        } else {
            $result = $this->runPart2($this->getInput(self::DATA_FILE));
        }

        Outputter::success("Result:");
        Outputter::success($result);
    }


    abstract protected function runPart1(Input $data): string;


    abstract protected function runPart2(Input $data): string;


    abstract protected function getExpectedTestResult1(): ?string;


    abstract protected function getExpectedTestResult2(): ?string;


    private function validateDayFolder(int $part): void
    {
        $folder = $this->getCurrentFolder();

        if ($part === 1 && !file_exists("$folder/" . self::TEST_DATA_FILE_1)
            && !file_exists("$folder/" . self::TEST_DATA_FILE_DEFAULT)
        ) {
            Outputter::errorFatal('Test data file 1 is missing!');
        }

        if ($part === 2 && !file_exists("$folder/" . self::TEST_DATA_FILE_2)
            && !file_exists("$folder/" . self::TEST_DATA_FILE_DEFAULT)
        ) {
            Outputter::errorFatal('Test data file 2 is missing!');
        }

        if (!file_exists("$folder/" . self::DATA_FILE)) {
            Outputter::errorFatal('Data file is missing!');
        }
    }


    protected function validateTestResult(int $part): void
    {
        if ($part === 1) {
            $expected = $this->getExpectedTestResult1();
            $real = $this->runPart1($this->getInput(self::TEST_DATA_FILE_1));
        } else {
            $expected = $this->getExpectedTestResult2();
            $real = $this->runPart2($this->getInput(self::TEST_DATA_FILE_2));
        }

        if ($expected === null) {
            Outputter::notice("Expected value for part $part not set. Skipping test.");

            return;
        }

        if ($expected !== $real) {
            Outputter::error("Test did not pass for part $part:");
            Outputter::error("Expected: '$expected'");
            Outputter::errorFatal("Returned: '$real'");
        }

        Outputter::success("The test for part $part succeeded with result '$real'.");
        Outputter::newline();
    }


    protected function getCurrentFolder(): string
    {
        $reflection = new ReflectionClass(static::class);

        return dirname($reflection->getFileName());
    }


    protected function getInput(string $fileName): Input
    {
        $folder = $this->getCurrentFolder();

        if (!file_exists("$folder/$fileName")) {
            $fileName = self::TEST_DATA_FILE_DEFAULT;
        }

        return new Input(file_get_contents("$folder/$fileName"));
    }
}
