<?php declare(strict_types = 1);

namespace App\Utils;

use InvalidArgumentException;

class Input
{
    private string $data;


    public function __construct(string $data)
    {
        $this->data = $data;
    }


    public function getAsString(): string
    {
        return $this->data;
    }


    /**
     * @return string[]
     */
    public function getAsArray(bool $filterLines = true, string $separator = "\n"): array
    {
        $dataExploded = explode($separator, $this->data);

        return ($filterLines === true ? array_filter($dataExploded) : $dataExploded);
    }


    /**
     * @return int[]
     */
    public function getAsArrayOfIntegers(bool $filterLines = true): array
    {
        return Tools::intifyArray($this->getAsArray($filterLines));
    }


    public function getAsArrayOfArrayOfIntegers(bool $filterLines = true, int $sliceLength = 1): array
    {
        $returnArray = [];
        foreach ($this->getAsArray($filterLines) as $line) {
            $returnArray[] = Tools::intifyArray(str_split($line, $sliceLength));
        }

        return $returnArray;
    }


    /**
     * @return array<int, array<int, string>>
     */
    public function getAsArrayOfArrays(
        bool $filterLines = true,
        string $lineSeparator = "\n",
        string $spaceSeparator = ' '
    ): array {
        if ($spaceSeparator === '') {
            throw new InvalidArgumentException('Space separator cannot be empty string!');
        }

        return array_map(
            static fn(string $line): array => explode($spaceSeparator, $line),
            $this->getAsArray($filterLines, $lineSeparator)
        );
    }


    /**
     * @return string[][]
     */
    public function getAsArrayOfChars(bool $filterLines = true): array
    {
        return array_map(
            static fn(string $line): array => str_split($line, 1),
            $this->getAsArray($filterLines)
        );
    }


    public function getFirstLine(bool $remove = false): string
    {
        if (strpos($this->data, "\n") === false) {
            return $this->data;
        }

        $firstLine = substr($this->data, 0, strpos($this->data, "\n"));
        if ($remove === true) {
            $this->data = substr($this->data, strpos($this->data, "\n"));
        }

        return $firstLine;
    }


    /**
     * @return int[]
     */
    public function getFirstLineAsIntegers(string $separator = ','): array
    {
        return Tools::intifyArray(explode($separator, $this->getFirstLine()));
    }
}
