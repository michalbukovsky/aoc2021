<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;
use App\Utils\Outputter;

class PassagePathing extends TwoPartRunner
{
    private const TRIES = 100000;


    protected function runPart1(Input $data): string
    {
        return $this->runSimulation($data, 1);
    }


    protected function runPart2(Input $data): string
    {
        return $this->runSimulation($data, 2);
    }


    private function runSimulation(Input $data, int $maxVisitsPerSmallCave): string
    {
        /** @var Node[] $nodes */
        $nodes = [];
        $duplicateRoutes = 0;

        foreach ($data->getAsArrayOfArrays(true, "\n", '-') as $line) {
            $nodeName = $line[0];
            $node1 = $nodes[$nodeName] ?? new Node($nodeName, $maxVisitsPerSmallCave);
            $nodes[$nodeName] = $node1;

            $nodeName = $line[1];
            $node2 = $nodes[$nodeName] ?? new Node($nodeName, $maxVisitsPerSmallCave);
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
                    $node = $node->getNextNodeRandom();
                } catch (NowhereToGoException $e) {
                    break;
                }

                $path .= '-' . $node->getName();
                if ($node->isEnd()) {
                    if (isset($paths[$path])) {
                        $duplicateRoutes++;

                        if ($duplicateRoutes > self::TRIES) {
                            break 2;
                        }
                        break;
                    }

                    $paths[$path] = true;
                    Outputter::notice($path);
                    break;
                }

                $node->markVisited();
            }
        }

        return (string)count($paths);
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
        return '10';
    }


    protected function getExpectedTestResult2(): ?string
    {
        return '36';
    }
}
