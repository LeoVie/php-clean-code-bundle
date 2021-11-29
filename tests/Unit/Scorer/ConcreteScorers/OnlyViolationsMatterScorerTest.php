<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Scorer\ConcreteScorers;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpCleanCode\Scorer\ConcreteScorers\OnlyViolationsMatterScorer;
use PHPUnit\Framework\TestCase;

class OnlyViolationsMatterScorerTest extends TestCase
{
    /** @dataProvider createProvider */
    public function testCreate(Score $expected, FileRuleResults $fileRuleResults): void
    {
        self::assertEquals($expected, (new OnlyViolationsMatterScorer())->create($fileRuleResults));
    }

    public function createProvider(): \Generator
    {
        yield 'no violations' => [
            'expected' => Score::create('OnlyViolationsMatter', 0),
            'fileRuleResults' => FileRuleResults::create('', RuleResultCollection::create([])),
        ];

        yield 'with violations' => [
            'expected' => Score::create('OnlyViolationsMatter', 35),
            'fileRuleResults' => FileRuleResults::create('', RuleResultCollection::create([
                $this->mockViolation(100.0),
                $this->mockViolation(5.0),
                $this->mockViolation(20.0),
                $this->mockViolation(15.0)
            ])),
        ];
    }

    private function mockViolation(float $criticality): Violation
    {
        $violation = $this->createMock(Violation::class);
        $violation->method('getCriticality')->willReturn($criticality);

        return $violation;
    }
}