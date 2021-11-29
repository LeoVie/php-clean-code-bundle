<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Model\Score;

use LeoVie\PhpCleanCode\Model\Score;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    public function testGetScoreType(): void
    {
        $scoreType = 'score type';

        self::assertSame($scoreType, Score::create($scoreType, 0)->getScoreType());
    }

    public function testGetPoints(): void
    {
        $points = 17;

        self::assertSame($points, Score::create('', $points)->getPoints());
    }

    public function testJsonSerialize(): void
    {
        $scoreType = 'score type';
        $points = 17;

        self::assertSame([
            'score_type' => $scoreType,
            'points' => $points,
        ], Score::create($scoreType, $points)->jsonSerialize());
    }
}