<?php

namespace LeoVie\PhpCleanCode\Scorer;

use Iterator;

class ScorerHolder
{
    /** @param Iterator<int, Scorer> $scorers */
    public function __construct(private iterable $scorers)
    {
    }

    /** @return Iterator<int, Scorer> */
    public function getScorers(): Iterator
    {
        return $this->scorers;
    }
}