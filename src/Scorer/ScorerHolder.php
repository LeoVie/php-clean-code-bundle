<?php

namespace LeoVie\PhpCleanCode\Scorer;

class ScorerHolder
{
    /** @param \Traversable<int, Scorer> $scorers */
    public function __construct(private iterable $scorers)
    {
    }

    /** @return \Traversable<int, Scorer> */
    public function getScorers(): iterable
    {
        return $this->scorers;
    }
}