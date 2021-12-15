<?php declare(strict_types = 1);

namespace App\Utils;

abstract class Tools
{
    /**
     * @return int[]
     */
    public static function strposAll(string $haystack, string $needle): array
    {
        $positions = [];
        $offset = 0;
        while (true) {
            $position = strpos($haystack, $needle, $offset);
            if ($position === false) {
                return $positions;
            }

            $positions[] = $position;
            $offset = $position + 1;
        }
    }


    /**
     * @param int[] $array
     *
     * @return array
     */
    public static function intifyArray(array $array): array
    {
        return array_map(
            static fn(string $line): int => (int)$line,
            $array
        );
    }


    public static function arraySumRecursive(array $array): int
    {
        $sum = 0;
        foreach ($array as $subArray) {
            $sum += array_sum($subArray);
        }

        return $sum;
    }


    public static function arrayMax(array $array): int
    {
        $max = 0;
        foreach ($array as $line) {
            $max = max($max, ...array_keys($line));
        }

        return $max;
    }
}