<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Tools;

class GiantSquid extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        return $this->play($data, true);
    }


    protected function runPart2(Input $data): string
    {
        return $this->play($data, false);
    }


    private function play(Input $data, bool $returnAfterFirstWin): string
    {
        $input = $data->getAsString();

        $draws = explode(',', substr($input, 0, strpos($input, "\n")));
        $draws = Tools::intifyArray($draws);

        $numbers = substr($input, strpos($input, "\n") + 2);
        $boards = [];

        foreach (explode("\n\n", $numbers) as $boardString) {
            $boards[] = Board::createFromString($boardString);
        }

        foreach ($draws as $draw) {
            foreach ($boards as $board) {
                try {
                    $board->drawNumber($draw);
                } catch (BingoException $e) {
                    if ($returnAfterFirstWin === true
                        || ($returnAfterFirstWin === false && $this->areAllBoardsWon($boards))
                    ) {
                        return (string)($e->getSumUndrawn() * $draw);
                    }
                }
            }
        }

        Outputter::errorFatal('No bingo found.');
        die;
    }


    private function areAllBoardsWon(array $boards): bool
    {
        return array_filter($boards, static fn(Board $board) => !$board->isWon()) === [];
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '4512';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '1924';
    }
}
