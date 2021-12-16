<?php declare(strict_types = 1);

namespace App;

use VisitedTwiceException;

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


    public function __construct(string $name)
    {
        $this->name = $name;
        $this->isStart = $name === self::START;
        $this->isEnd = $name === self::END;
        $this->isSmall = (bool)preg_match('~[a-z]+~', $name);
        $this->availableNodes = $this->nodes;
        $this->visits = 0;
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


    public function getNextNodeRandom(int $maxVisitsPerSmall): Node
    {
        $this->availableNodes = array_filter(
            $this->availableNodes,
            static fn(Node $node) => $node->isEnterable($maxVisitsPerSmall)
        );
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


    public function isEnterable(int $maxVisitsPerSmall): bool
    {
        return !$this->isSmall || $this->visits < $maxVisitsPerSmall;
    }


    /**
     * @throws VisitedTwiceException
     */
    public function markVisited(): void
    {
        $this->visits++;
        if ($this->isSmall && $this->visits >= 2) {
            throw new VisitedTwiceException();
        }
    }
}
