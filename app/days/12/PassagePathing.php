<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class PassagePathing extends TwoPartRunner
{
    const MAX_DUPLICATES = 10;


    protected function runPart1(Input $data): string
    {
        /** @var Node[] $nodes */
        $nodes = [];
        $duplicateRoutes = 0;

        foreach ($data->getAsArrayOfArrays(true, "\n", '-') as $line) {
            $nodeName = $line[0];
            $node1 = $nodes[$nodeName] ?? new Node($nodeName);
            $nodes[$nodeName] = $node1;

            $nodeName = $line[1];
            $node2 = $nodes[$nodeName] ?? new Node($nodeName);
            $nodes[$nodeName] = $node2;

            $node1->addNode($node2);
            $node2->addNode($node1);
        }

        $paths = [];
        while (true) {
            $this->resetNodes($nodes);
            $node = $nodes[Node::START];
            $path = $node->getName();

            while (true) {
                try {
                    $node = $node->getNextNode();
                } catch (NowhereToGoException $e) {
                    break;
                }

                $path .= $node->getName();
                if ($node->isEnd()) {
                    if (isset($paths[$path])) {
                        $duplicateRoutes++;

                        if ($duplicateRoutes > self::MAX_DUPLICATES) {
                            break 2;
                        }
                        break;
                    }

                    $paths[$path] = true;
                    break;
                }

                $node->markVisited();
            }
        }

        return (string)count($paths);
    }


    protected function runPart2(Input $data): string
    {
        return '';
    }


    /**
     * @param Node[] $nodes
     */
    private function resetNodes(array $nodes): void
    {
        foreach ($nodes as $node) {
            $node->reset();
        }
    }


    protected function getExpectedTestResult1(): ?string
    {
        return '19';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '';
    }
}
