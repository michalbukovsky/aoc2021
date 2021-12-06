<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class HydrothermalVenture extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        $map = [];

        foreach ($data->getAsArray() as $line) {
            preg_match('~(\d+),(\d+) -> (\d+),(\d+)~', $line, $m);
            [1 => $x1, 2 => $y1, 3 => $x2, 4 => $y2] = $m;

            if ($x1 !== $x2 && $y1 !== $y2) {
                continue;
            }

            $this->makeVentLine($map, (int)$x1, (int)$y1, (int)$x2, (int)$y2);
        }

        return (string)$this->getDangerousAreas($map);
    }


    protected function runPart2(Input $data): string
    {
        $map = [];

        foreach ($data->getAsArray() as $line) {
            preg_match('~(\d+),(\d+) -> (\d+),(\d+)~', $line, $m);
            [1 => $x1, 2 => $y1, 3 => $x2, 4 => $y2] = $m;

            $this->makeVentLine($map, (int)$x1, (int)$y1, (int)$x2, (int)$y2);
        }

        return (string)$this->getDangerousAreas($map);
    }


    private function makeVentLine(array &$map, int $x1, int $y1, int $x2, int $y2): void
    {
        $currentX = $x1;
        $currentY = $y1;
        $map[$currentY][$currentX]++;

        do {
            $currentX += ($x2 - $x1) <=> 0;
            $currentY += ($y2 - $y1) <=> 0;

            $map[$currentY][$currentX]++;
        } while ($currentX !== $x2 || $currentY !== $y2);
    }


    private function getDangerousAreas(array &$map): int
    {
        $count = 0;
        foreach ($map as $line) {
            foreach ($line as $spot) {
                if ($spot > 1) {
                    $count++;
                }
            }
        }

        return $count;
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '5';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '12';
    }
}
