<?php declare(strict_types = 1);

namespace App\Utils;

use Iterator;

class SmartString implements Iterator
{
    private string $string;

    private int $currentIndex;

    private int $length;


    public function __construct(string $string)
    {
        $this->string = $string;
        $this->length = strlen($this->string);
    }


    public function current(): string
    {
        return $this->string[$this->currentIndex];
    }


    public function next(): void
    {
        ++$this->currentIndex;
    }


    public function key(): int
    {
        return $this->currentIndex;
    }


    public function valid(): bool
    {
        return $this->currentIndex >= 0 && $this->currentIndex < $this->length;
    }


    public function rewind(): void
    {
        $this->currentIndex = 0;
    }


    public function __toString(): string
    {
        return $this->string;
    }


    public function getLength(): int
    {
        return $this->length;
    }


    public function reverse(): void
    {
        $this->string = strrev($this->string);
    }
}