<?php

namespace LeoVie\PhpCleanCode\Scorer;

class ScorerHolder
{
    /** @param iterable<int, Scorer> $scorers */
    public function __construct(private iterable $scorers)
    {
    }

    /** @return iterable<int, Scorer> */
    public function getScorers(): iterable
    {
        return $this->scorers;
    }
}