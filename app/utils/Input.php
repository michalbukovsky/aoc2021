<?php declare(strict_types = 1);

namespace App\Utils;

class Input
{
    private string $data;


    public function __construct(string $data)
    {
        $this->data = $data;
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
    public function getAsInegersArray(bool $filterLines = true): array
    {
        return array_map(
            static fn(string $line): int => (int)$line,
            $this->getAsArray($filterLines)
        );
    }


    /**
     * @return array<int, array<int, string>>
     */
    public function getAsArrayOfArrays(
        bool $filterLines = true,
        string $lineSeparator = "\n",
        string $spaceSeparator = ' '
    ): array {
        return array_map(
            static fn(string $line): array => explode($spaceSeparator, $line),
            $this->getAsArray($filterLines, $lineSeparator)
        );
    }
}
