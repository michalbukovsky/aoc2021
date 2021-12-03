<?php declare(strict_types = 1);

namespace App;

use App\Utils\Bitwise;
use App\Utils\Input;

class BinaryDiagnostic extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        $currentBitPosition = 0;
        $length = strlen($data->getFirstLine());
        $gamma = '';

        do {
            $foundBits = ['0' => 0, '1' => 0];
            foreach ($data->getAsArray() as $currentBinaryNumber) {
                $currentBit = $currentBinaryNumber[$currentBitPosition];
                $foundBits[$currentBit]++;
            }

            $gamma .= $foundBits['0'] > $foundBits['1'] ? '0' : '1';
        } while (++$currentBitPosition < $length);

        $epsilon = Bitwise::not($gamma);

        return (string)(bindec($epsilon) * bindec($gamma));
    }


    protected function runPart2(Input $data): string
    {
        return '';
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '198';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '230';
    }
}
