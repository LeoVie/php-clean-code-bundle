<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Scorer;

use LeoVie\PhpCleanCode\Scorer\Scorer;
use LeoVie\PhpCleanCode\Scorer\ScorerHolder;
use PHPUnit\Framework\TestCase;

class ScorerHolderTest extends TestCase
{
    public function testGetScorers(): void
    {
        /** @var \Iterator<int, Scorer> $scorersIterator */
        $scorersIterator = new \ArrayIterator([
            $this->mockScorer(),
            $this->mockScorer(),
            $this->mockScorer(),
        ]);

        self::assertEquals($scorersIterator, (new ScorerHolder($scorersIterator))->getScorers());
    }

    private function mockScorer(): Scorer
    {
        return $this->createMock(Scorer::class);
    }
}