<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Tools;

class Lanternfish extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        return $this->simulate($data, 80);
    }


    protected function runPart2(Input $data): string
    {
        return $this->simulate($data, 256);
    }


    private function simulate(Input $data, int $days): string
    {
        $day = 1;
        $fishesByDay = [];
        foreach (Tools::intifyArray(explode(',', $data->getFirstLine())) as $fishInt) {
            $fishesByDay[$fishInt]++;
        }

        do {
            ksort($fishesByDay);

            for ($daysToReproduction = 0; $daysToReproduction <= 9; $daysToReproduction++) {
                $fishes = $fishesByDay[$daysToReproduction] ?? 0;
                if ($fishes === 0) {
                    continue;
                }

                if ($daysToReproduction === 0) {
                    $fishesByDay[9] = $fishes;
                    $fishesByDay[7] += $fishes;
                    $fishesByDay[0] = 0;
                    continue;
                }

                $fishesByDay[$daysToReproduction - 1] += $fishes;
                $fishesByDay[$daysToReproduction] -= $fishes;
            }
        } while (++$day <= $days);

        return (string)array_sum($fishesByDay);
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '5934';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '26984457539';
    }
}
