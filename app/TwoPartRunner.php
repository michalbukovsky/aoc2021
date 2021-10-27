<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Output;
use ReflectionClass;

abstract class TwoPartRunner implements IRunner
{
    protected const TEST_DATA_FILE = 'test.txt';
    protected const DATA_FILE = 'data.txt';


    public function run(int $part): void
    {
        $this->validateDayFolder();

        if (!in_array($part, [1, 2], true)) {
            Output::errorFatal("Invalid part '$part'.");
        }

        $this->validateTestResult($part);

        if ($part === 1) {
            $result = $this->runPart1($this->getInput(false));
        } else {
            $result = $this->runPart2($this->getInput(false));
        }

        Output::success($result);
    }


    abstract protected function runPart1(Input $data): string;


    abstract protected function runPart2(Input $data): string;


    abstract protected function getExpectedTestResult1(): string;


    abstract protected function getExpectedTestResult2(): string;


    protected function validateDayFolder(): void
    {
        $folder = $this->getCurrentFolder();

        if (!file_exists("$folder/" . self::TEST_DATA_FILE)) {
            Output::errorFatal('Test data file is missing!');
        }

        if (!file_exists("$folder/" . self::DATA_FILE)) {
            Output::errorFatal('Data file is missing!');
        }
    }


    protected function validateTestResult(int $part): void
    {
        if ($part === 1) {
            $expected = $this->getExpectedTestResult1();
            $real = $this->runPart1($this->getInput(true));
        } else {
            $expected = $this->getExpectedTestResult2();
            $real = $this->runPart2($this->getInput(true));
        }

        if ($expected !== $real) {
            Output::error("Test did not pass for part $part:");
            Output::error("Expected: '$expected'");
            Output::errorFatal("Returned: '$real'");
        }
    }


    protected function getCurrentFolder(): string
    {
        $reflection = new ReflectionClass(static::class);

        return dirname($reflection->getFileName());
    }


    protected function getInput(bool $isTestFile): Input
    {
        $folder = $this->getCurrentFolder();
        $fileName = $isTestFile ? self::TEST_DATA_FILE : self::DATA_FILE;

        return new Input(file_get_contents("$folder/$fileName"));
    }
}
