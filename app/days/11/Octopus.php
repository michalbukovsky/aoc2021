<?php declare(strict_types = 1);

namespace App;

class Octopus
{
    private const MAX_ENERGY = 9;

    private int $energy;

    private int $lastFlash = 0;


    public function __construct(int $energy)
    {
        $this->energy = $energy;
    }


    /**
     * @return bool Flash?
     */
    public function addEnergy(int $time): bool
    {
        if ($this->lastFlash === $time) {
            return false;
        }
        if (++$this->energy > self::MAX_ENERGY) {
            $this->energy = 0;
            $this->lastFlash = $time;

            return true;
        }

        return false;
    }
}
