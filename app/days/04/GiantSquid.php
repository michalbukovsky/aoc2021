<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Outputter;
use App\Utils\Tools;

class GiantSquid extends TwoPartRunner
{
    protected function runPart1(Input $data): string
    {
        $input = $data->getAsString();

        $draws = explode(',', substr($input, 0, strpos($input, "\n")));
        $draws = Tools::intifyArray($draws);

        $numbers = substr($input, strpos($input, "\n") + 2);
        $boards = [];

        foreach (explode("\n\n", $numbers) as $boardString) {
            $boards[] = Board::createFromString($boardString);
        }

        try {
            foreach ($draws as $draw) {
                foreach ($boards as $board) {
                    $board->drawNumber($draw);
                }
            }
        } catch (BingoException $e) {
            return (string)($e->getSumUndrawn() * $draw);
        }

        Outputter::errorFatal('No bingo found.');
        die;
    }


    protected function runPart2(Input $data): string
    {
        return '';
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '4512';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '';
    }
}
