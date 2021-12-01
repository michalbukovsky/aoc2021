<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class SonarSweep extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        $lastNumber = null;
        $increments = 0;

        foreach ($data->getAsArrayOfIntegers() as $number) {
            if ($lastNumber === null) {
                $lastNumber = $number;
                continue;
            }

            if ($number > $lastNumber) {
                $increments++;
            }

            $lastNumber = $number;
        }

        return (string)$increments;
    }


    protected function runPart2(Input $data): string
    {
        $numbers = $data->getAsArrayOfIntegers();
        $lastSum = null;
        $increments = 0;

        $i = -1;
        while (isset($numbers[++$i + 2])) {
            $sum = $numbers[$i] + $numbers[$i + 1] + $numbers[$i + 2];

            if ($lastSum === null) {
                $lastSum = $sum;
                continue;
            }

            if ($sum > $lastSum) {
                $increments++;
            }

            $lastSum = $sum;
        }

        return (string)$increments;
    }


    protected function getExpectedTestResult1(): string
    {
        return '7';
    }


    protected function getExpectedTestResult2(): string
    {
        return '5';
    }
}