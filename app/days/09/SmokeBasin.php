<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class SmokeBasin extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        $lowSpotsSum = 0;

        $map = $data->getAsArrayOfArrayOfIntegers(true);
        foreach ($map as $y => $line) {
            foreach ($line as $x => $value) {
                $neighbors = $this->getNeighborsValues($map, $x, $y);
                if ($value < $neighbors[0]) {
                    $lowSpotsSum += 1 + $value;
                }
            }
        }

        return (string)$lowSpotsSum;
    }


    protected function runPart2(Input $data): string
    {
        return '';
    }


    /**
     * @return int[]
     */
    private function getNeighborsValues(array $map, int $xCenter, int $yCenter): array
    {
        $neighbors = [];

        for ($rad = 0; $rad < 2 * M_PI; $rad += M_PI / 2) {
            $x = $xCenter + (int)sin($rad);
            $y = $yCenter + (int)cos($rad);
            if (!isset($map[$y][$x])) {
                continue;
            }

            $neighbors[] = $map[$y][$x];
        }

        sort($neighbors);

        return $neighbors;
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '15';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '';
    }
}
