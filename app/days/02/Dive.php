<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class Dive extends TwoPartRunner
{
    private const FORWARD = 'forward';
    private const UP = 'up';
    private const DOWN = 'down';


    protected function runPart1(Input $data): string
    {
        $x = 0;
        $y = 0;

        foreach ($data->getAsArray() as $line) {
            $direction = substr($line, 0, -2);
            $distance = (int)substr($line, -1);

            if ($direction === self::FORWARD) {
                $x += $distance;
            } elseif ($direction === self::UP) {
                $y -= $distance;
            } elseif ($direction === self::DOWN) {
                $y += $distance;
            }
        }

        return (string)($x * $y);
    }


    protected function runPart2(Input $data): string
    {
        $aim = 0;
        $x = 0;
        $y = 0;

        foreach ($data->getAsArray() as $line) {
            $direction = substr($line, 0, -2);
            $distance = (int)substr($line, -1);

            if ($direction === self::FORWARD) {
                $x += $distance;
                $y += $aim * $distance;
            } elseif ($direction === self::UP) {
                $aim -= $distance;
            } elseif ($direction === self::DOWN) {
                $aim += $distance;
            }
        }

        return (string)($x * $y);
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '150';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '900';
    }
}
