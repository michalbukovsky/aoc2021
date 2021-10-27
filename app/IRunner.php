<?php declare(strict_types = 1);

namespace App;

interface IRunner
{
    public function run(int $part): void;
}
