<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class TheTreacheryOfWhales extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        return $this->simulateFuelConsumption($data, false);
    }


    protected function runPart2(Input $data): string
    {
        return $this->simulateFuelConsumption($data, true);
    }


    private function simulateFuelConsumption(Input $data, bool $incremental): string
    {
        $crabs = $data->getFirstLineAsIntegers();
        sort($crabs);
        $max = end($crabs);
        $min = reset($crabs);
        $fuelConsumptionByPosition = [];

        for ($destination = $min; $destination < $max; $destination++) {
            $fuelConsumptionByPosition[$destination] = $this->getFuelToDestination($crabs, $destination, $incremental);
        }

        sort($fuelConsumptionByPosition);

        return (string)$fuelConsumptionByPosition[0];
    }


    private function getFuelToDestination(array $crabs, int $destination, bool $incremental): int
    {
        $fuel = 0;
        foreach ($crabs as $crab) {
            if ($incremental === false) {
                $fuel += abs($destination - $crab);
                continue;
            }

            $range = range(1, abs($destination - $crab));
            $fuel += array_sum($range);
        }

        return $fuel;
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '37';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '168';
    }
}
