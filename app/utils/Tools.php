<?php declare(strict_types=1);

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
}