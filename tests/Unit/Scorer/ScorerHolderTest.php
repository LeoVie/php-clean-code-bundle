<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Scorer;

use LeoVie\PhpCleanCode\Scorer\Scorer;
use LeoVie\PhpCleanCode\Scorer\ScorerHolder;
use PHPUnit\Framework\TestCase;

class ScorerHolderTest extends TestCase
{
    public function testGetScorers(): void
    {
        $scorers = [
            $this->mockScorer(),
            $this->mockScorer(),
            $this->mockScorer(),
        ];
        /** @var \Iterator<int, Scorer> $scorersIterator */
        $scorersIterator = new \ArrayIterator($scorers);

        self::assertEquals($scorers, (new ScorerHolder($scorersIterator))->getScorers());
    }

    private function mockScorer(): Scorer
    {
        return $this->createMock(Scorer::class);
    }
}