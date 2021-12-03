<?php declare(strict_types = 1);

namespace App\Utils;

abstract class Bitwise
{
    public static function not(string $binaryNumber): string
    {
        $pos = -1;
        $output = '';
        while (isset($binaryNumber[++$pos])) {
            $output .= $binaryNumber[$pos] === '0' ? '1' : '0';
        }

        return $output;
    }
}
