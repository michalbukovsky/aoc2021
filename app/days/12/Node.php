<?php declare(strict_types = 1);

namespace App;

class Node
{
    public const START = 'start';
    public const END = 'end';

    /** @var Node[] */
    private array $nodes = [];

    /** @var Node[] */
    private array $availableNnodes = [];

    private string $name;

    private int $nextNodeIndex = 0;

    private bool $isStart;

    private bool $isEnd;

    private bool $isSmall;

    private bool $visited = false;


    public function __construct(string $name)
    {
        $this->name = $name;
        $this->isStart = $name === self::START;
        $this->isEnd = $name === self::END;
        $this->isSmall = (bool)preg_match('~[a-z]+~', $name);
        $this->availableNnodes = $this->nodes;
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
        $this->availableNnodes[] = $node;
    }


    /**
     * @throws NowhereToGoException
     */
    public function getNextNode(): Node
    {
        while (true) {
            if ($this->availableNnodes === []) {
                throw new NowhereToGoException();
            }

            if ($this->nextNodeIndex >= count($this->availableNnodes)) {
                $this->nextNodeIndex = 0;
            }

            $nextNode = $this->availableNnodes[$this->nextNodeIndex];
            if (!$nextNode->isEnterable()) {
                unset($this->availableNnodes[$this->nextNodeIndex]);
                $this->availableNnodes = array_values($this->availableNnodes);
                continue;
            }

            $this->nextNodeIndex++;

            return $nextNode;
        }
    }


    public function reset(): void
    {
        $this->visited = false;
        $this->availableNnodes = $this->nodes;
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
        return !$this->isSmall || !$this->visited;
    }


    public function markVisited(): void
    {
        $this->visited = true;
    }
}
