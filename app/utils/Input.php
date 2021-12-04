<?php declare(strict_types = 1);

namespace App\Utils;

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


    /**
     * @return array<int, array<int, string>>
     */
    public function getAsArrayOfArrays(
        bool $filterLines = true,
        string $lineSeparator = "\n",
        string $spaceSeparator = ' '
    ): array {
        if ($spaceSeparator === '') {
            throw new \InvalidArgumentException('Space separator cannot be empty string!');
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


    public function getFirstLine(): string
    {
        return substr($this->data, 0, strpos($this->data, "\n"));
    }
}
