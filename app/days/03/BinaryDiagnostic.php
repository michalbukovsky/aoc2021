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
            $foundBits = $this->getValuesCounts($data->getAsArray(), $currentBitPosition);
            $gamma .= $foundBits['0'] > $foundBits['1'] ? '0' : '1';
        } while (++$currentBitPosition < $length);

        $epsilon = Bitwise::not($gamma);

        return (string)(bindec($epsilon) * bindec($gamma));
    }


    protected function runPart2(Input $data): string
    {
        $result1 = $this->getResultForPart2($data, '1', '0');
        $result2 = $this->getResultForPart2($data, '0', '1');

        return (string)($result1 * $result2);
    }


    private function getResultForPart2(Input $data, string $removeIfMajority, string $removeIfMinority): int
    {
        $length = strlen($data->getFirstLine());
        $remainingData = $data->getAsArray();
        $currentBitPosition = 0;
        do {
            $foundBits = $this->getValuesCounts($remainingData, $currentBitPosition);
            $valueToRemove = $foundBits['0'] > $foundBits['1'] ? $removeIfMajority : $removeIfMinority;
            $remainingData = $this->removeByValueAndPosition($remainingData, $currentBitPosition, $valueToRemove);
        } while (count($remainingData) > 1 && ++$currentBitPosition < $length);

        return (int)bindec($remainingData[0]);
    }


    /**
     * @param string[] $data
     *
     * @return array<string, int> ['0' => count, '1' => count]
     */
    private function getValuesCounts(array $data, int $currentBitPosition): array
    {
        $foundBits = ['0' => 0, '1' => 0];
        foreach ($data as $currentBinaryNumber) {
            $currentBit = $currentBinaryNumber[$currentBitPosition];
            $foundBits[$currentBit]++;
        }

        return $foundBits;
    }


    /**
     * @param string[] $data
     *
     * @return string[]
     */
    private function removeByValueAndPosition(array $data, int $bitPosition, string $value): array
    {
        $i = 0;
        foreach ($data as $number) {
            if ($number[$bitPosition] === $value) {
                unset($data[$i]);
            }
            ++$i;
        }

        return array_values($data);
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
