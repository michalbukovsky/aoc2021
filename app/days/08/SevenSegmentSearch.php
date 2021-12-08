<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class SevenSegmentSearch extends TwoPartRunner
{
    private const PART_1_ACCEPTED_LENGTHS = [2, 3, 4, 7];


    protected function runPart1(Input $data): string
    {
        $occurrences = 0;

        foreach ($data->getAsArray() as $line) {
            $digits = explode(' ', substr($line, strpos($line, '|') + 2));
            foreach ($digits as $digit) {
                if (in_array(strlen($digit), self::PART_1_ACCEPTED_LENGTHS, true)) {
                    $occurrences++;
                }
            }
        }

        return (string)$occurrences;
    }


    protected function runPart2(Input $data): string
    {
        return '';
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '26';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '';
    }
}
