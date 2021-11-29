<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Scorer\ConcreteScorers;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpCleanCode\Scorer\ConcreteScorers\CompliancesAndViolationsMatterScorer;
use LeoVie\PhpCleanCode\Scorer\ConcreteScorers\OnlyViolationsMatterScorer;
use PHPUnit\Framework\TestCase;

class CompliancesAndViolationsMatterScorerTest extends TestCase
{
    /** @dataProvider createProvider */
    public function testCreate(Score $expected, FileRuleResults $fileRuleResults): void
    {
        self::assertEquals($expected, (new CompliancesAndViolationsMatterScorer())->create($fileRuleResults));
    }

    public function createProvider(): \Generator
    {
        yield 'no violations' => [
            'expected' => Score::create('CompliancesAndViolationsMatter', 0),
            'fileRuleResults' => FileRuleResults::create('', RuleResultCollection::create([])),
        ];

        yield 'with violations' => [
            'expected' => Score::create('CompliancesAndViolationsMatter', 35),
            'fileRuleResults' => FileRuleResults::create('', RuleResultCollection::create([
                $this->mockViolation(115.2),
                $this->mockCompliance(),
                $this->mockViolation(25.0),
                $this->mockCompliance(),
            ])),
        ];
    }

    private function mockViolation(float $criticality): Violation
    {
        $violation = $this->createMock(Violation::class);
        $violation->method('getCriticality')->willReturn($criticality);

        return $violation;
    }

    private function mockCompliance(): Compliance
    {
        return $this->createMock(Compliance::class);
    }
}