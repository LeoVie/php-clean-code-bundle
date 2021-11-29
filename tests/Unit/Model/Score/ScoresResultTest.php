<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Model\Score;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Model\ScoresResult;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use PHPUnit\Framework\TestCase;

class ScoresResultTest extends TestCase
{
    public function testGetFileRuleResults(): void
    {
        $fileRuleResults = FileRuleResults::create('', RuleResultCollection::create([]));

        self::assertSame($fileRuleResults, ScoresResult::create($fileRuleResults, [])->getFileRuleResults());
    }

    public function testGetScores(): void
    {
        $fileRuleResults = FileRuleResults::create('', RuleResultCollection::create([]));
        $scores = [
            Score::create('', 1),
            Score::create('', 2),
            Score::create('', 3),
        ];

        self::assertSame($scores, ScoresResult::create($fileRuleResults, $scores)->getScores());
    }
}