<?php declare(strict_types = 1);

namespace App;

class Node
{
    public const START = 'start';
    public const END = 'end';

    /** @var Node[] */
    private array $nodes = [];

    /** @var Node[] */
    private array $availableNodes;

    private string $name;

    private bool $isStart;

    private bool $isEnd;

    private bool $isSmall;

    private int $visits;

    private int $maxVisitsPerSmall;


    public function __construct(string $name, int $maxVisitsPerSmall = 1)
    {
        $this->name = $name;
        $this->isStart = $name === self::START;
        $this->isEnd = $name === self::END;
        $this->isSmall = (bool)preg_match('~[a-z]+~', $name);
        $this->availableNodes = $this->nodes;
        $this->visits = 0;
        $this->maxVisitsPerSmall = $maxVisitsPerSmall;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function addNode(Node $node): void
    {
        if ($this->isEnd) {
            return;
        }
        if ($node->isStart()) {
            return;
        }

        $this->nodes[] = $node;
        $this->availableNodes[] = $node;
    }


    public function getNextNodeRandom(): Node
    {
        $this->availableNodes = array_filter($this->availableNodes, static fn(Node $node) => $node->isEnterable());
        if ($this->availableNodes === []) {
            throw new NowhereToGoException();
        }

        return $this->availableNodes[array_rand($this->availableNodes)];
    }


    public function reset(): void
    {
        $this->visits = 0;
        $this->availableNodes = $this->nodes;
    }


    public function isStart(): bool
    {
        return $this->isStart;
    }


    public function isEnd(): bool
    {
        return $this->isEnd;
    }


    public function isEnterable(): bool
    {
        return !$this->isSmall || $this->visits < $this->maxVisitsPerSmall;
    }


    public function markVisited(): void
    {
        $this->visits++;
    }
}
