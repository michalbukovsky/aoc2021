<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class SevenSegmentSearch extends TwoPartRunner
{
    private const PART_1_ACCEPTED_LENGTHS = [2, 3, 4, 7];
    private const NUMBERS_BY_SEGMENTS = [
        '124567' => 0,
        '47' => 1,
        '13456' => 2,
        '13467' => 3,
        '2347' => 4,
        '12367' => 5,
        '123567' => 6,
        '147' => 7,
        '1234567' => 8,
        '123467' => 9,
    ];


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
        $sum = 0;

        foreach ($data->getAsArray() as $line) {
            $digitsString = explode(' ', substr($line, 0, strpos($line, '|') - 1));
            $digitsSolutionString = explode(' ', substr($line, strpos($line, '|') + 2));

            $digits = [];
            foreach ($digitsString as $digitString) {
                $digits[] = str_split($digitString);
            }

            $segmentsResults = $this->solveSegments($digits);

            $resultNumber = '';
            foreach ($digitsSolutionString as $solutionDigit) {
                $litSegments = [];
                foreach (str_split($solutionDigit) as $solutionSegment) {
                    $litSegments[] = $segmentsResults[$solutionSegment];
                }
                sort($litSegments);
                $resultNumber .= self::NUMBERS_BY_SEGMENTS[implode('', $litSegments)];
            }

            $sum += (int)$resultNumber;
        }

        return (string)$sum;
    }


    private function solveSegments(array $digits): array
    {
        $segs = [];

        $one = $this->filterDigitsByLength($digits, 2)[0];
        $seven = $this->filterDigitsByLength($digits, 3)[0];
        $segs[1] = $this->diff($seven, $one);

        $four = $this->filterDigitsByLength($digits, 4)[0];
        $segment23 = $this->diff($four, $one);

        $eight = $this->filterDigitsByLength($digits, 7)[0];
        $segment56 = $this->diff($eight, $four, $seven);

        $zeros = $this->filterDigitsByLength($digits, 6);
        foreach ($zeros as $zero) {
            $segs[3] = $this->diff($eight, $zero);
            if ($this->diff($segs[3], $segment23) === []) {
                break;
            }
        }

        $segs[2] = $this->diff($segment23, $segs[3]);

        $fives = $this->filterDigitsByLength($digits, 5);
        foreach ($fives as $five) {
            if (count($this->diff($five, $segs[1], $segs[2], $segs[3])) === 2) {
                break;
            }
        }

        $segs[4] = $this->diff($one, $five);
        $segs[7] = $this->diff($one, $segs[4]);
        $segs[5] = $this->diff($segment56, $five);
        $segs[6] = $this->diff($segment56, $segs[5]);

        return $this->flipSegmentsArray($segs);
    }


    /**
     * @param string[][] $digits
     * @param int $length
     *
     * @return string[][]
     */
    private function filterDigitsByLength(array $digits, int $length): array
    {
        return array_values(array_filter($digits, static fn(array $digit) => count($digit) === $length));
    }


    private function diff(array $array1, ...$arrays): array
    {
        return array_values(array_diff($array1, ...$arrays));
    }


    private function flipSegmentsArray(array $segments): array
    {
        $transformedArray = [];
        foreach ($segments as $segmentIndex => $segment) {
            $transformedArray[$segment[0]] = $segmentIndex;
        }

        return $transformedArray;
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '26';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '61229';
    }
}
