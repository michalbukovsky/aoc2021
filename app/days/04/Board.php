<?php declare(strict_types = 1);

namespace App;

use App\Utils\Tools;

class Board
{
    private const COUNT = 5;

    /**
     * @var int[][]
     */
    private array $lines;


    public static function createFromString(string $inputString): self
    {
        $resultArray = [];
        $inputString = (string)preg_replace('~(\d) +~', '$1,', $inputString);

        $lines = explode("\n", $inputString);
        foreach ($lines as $line) {
            $lineArray = explode(',', $line);
            $resultArray[] = array_map('intval', $lineArray);
        }

        return new self($resultArray);
    }


    /**
     * @param int[][] $lines
     */
    public function __construct(array $lines)
    {
        $this->lines = $lines;
    }


    /**
     * @param int $draw
     *
     * @throws BingoException
     */
    public function drawNumber(int $draw): void
    {
        foreach ($this->lines as $y => $line) {
            $this->lines[$y] = array_filter($line, static fn(int $number) => $number !== $draw, ARRAY_FILTER_USE_BOTH);
        }

        $this->checkBingo();
    }


    /**
     * @throws BingoException
     */
    private function checkBingo(): void
    {
        $columnCounts = array_fill(0, self::COUNT, 0);
        foreach ($this->lines as $line) {
            if ($line === []) {
                throw new BingoException(Tools::arraySumRecursive($this->lines));
            }

            for ($i = 0; $i < self::COUNT; $i++) {
                if (isset($line[$i])) {
                    $columnCounts[$i]++;
                }
            }
        }
        if (in_array(0, $columnCounts, true)) {
            throw new BingoException(Tools::arraySumRecursive($this->lines));
        }
    }
}