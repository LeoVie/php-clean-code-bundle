<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\RuleResult;

use LeoVie\PhpCleanCode\Rule\RuleConcept\Rule;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use PHPUnit\Framework\TestCase;

class RuleResultCollectionTest extends TestCase
{
    /** @dataProvider getRuleResultsProvider */
    public function testGetRuleResults(array $expected, array $ruleResults): void
    {
        self::assertSame($expected, RuleResultCollection::create($ruleResults)->getRuleResults());
    }

    public function getRuleResultsProvider(): array
    {
        $ruleResults = [
            '01-Rule' => $this->mockRuleResult('01-Rule'),
            '02-Rule (#1)' => $this->mockRuleResult('02-Rule'),
            '02-Rule (#2)' => $this->mockRuleResult('02-Rule'),
            '03-Rule' => $this->mockRuleResult('03-Rule'),
        ];

        return [
            'empty' => [
                'expected' => [],
                'ruleResults' => [],
            ],
            'sorted' => [
                'expected' => array_values($ruleResults),
                'ruleResults' => array_values($ruleResults),
            ],
            'unsorted' => [
                'expected' => array_values($ruleResults),
                'ruleResults' => [
                    $ruleResults['02-Rule (#1)'],
                    $ruleResults['01-Rule'],
                    $ruleResults['02-Rule (#2)'],
                    $ruleResults['03-Rule'],
                ],
            ],
        ];
    }

    private function mockRuleResult(string $ruleName): RuleResult
    {
        $ruleResult = $this->createMock(RuleResult::class);
        $rule = $this->createMock(Rule::class);
        $rule->method('getName')->willReturn($ruleName);
        $ruleResult->method('getRule')->willReturn($rule);

        return $ruleResult;
    }

    /** @dataProvider getViolationsProvider */
    public function testGetViolations(array $expected, array $ruleResults): void
    {
        self::assertSame($expected, RuleResultCollection::create($ruleResults)->getViolations());
    }

    public function getViolationsProvider(): array
    {
        $violations = [
            $this->mockViolation(),
            $this->mockViolation(),
        ];
        $compliances = [
            $this->mockCompliance(),
            $this->mockCompliance(),
        ];

        return [
            'with violations and compliances' => [
                'expected' => $violations,
                'ruleResults' => array_merge($compliances, $violations),
            ],
            'with only violations' => [
                'expected' => $violations,
                'ruleResults' => $violations,
            ],
            'with only compliances' => [
                'expected' => [],
                'ruleResults' => $compliances,
            ],
            'with nothing' => [
                'expected' => [],
                'ruleResults' => [],
            ],
        ];
    }

    private function mockViolation(array $jsonSerialized = []): Violation
    {
        $violation = $this->createMock(Violation::class);
        $violation->method('jsonSerialize')->willReturn($jsonSerialized);

        return $violation;
    }

    private function mockCompliance(array $jsonSerialized = []): Compliance
    {
        $compliance = $this->createMock(Compliance::class);
        $compliance->method('jsonSerialize')->willReturn($jsonSerialized);

        return $compliance;
    }

    /** @dataProvider getCompliancesProvider */
    public function testGetCompliances(array $expected, array $ruleResults): void
    {
        self::assertSame($expected, RuleResultCollection::create($ruleResults)->getCompliances());
    }

    public function getCompliancesProvider(): array
    {
        $violations = [
            $this->mockViolation(),
            $this->mockViolation(),
        ];
        $compliances = [
            $this->mockCompliance(),
            $this->mockCompliance(),
        ];

        return [
            'with violations and compliances' => [
                'expected' => $compliances,
                'ruleResults' => array_merge($violations, $compliances),
            ],
            'with only compliances' => [
                'expected' => $compliances,
                'ruleResults' => $compliances,
            ],
            'with only violations' => [
                'expected' => [],
                'ruleResults' => $violations,
            ],
            'with nothing' => [
                'expected' => [],
                'ruleResults' => [],
            ],
        ];
    }

    /** @dataProvider jsonSerializeProvider */
    public function testJsonSerialize(array $expected, array $violations, array $compliances): void
    {
        self::assertSame(
            $expected,
            RuleResultCollection::create(array_merge($violations, $compliances))->jsonSerialize()
        );
    }

    public function jsonSerializeProvider(): array
    {
        return [
            [
                'expected' => [
                    'violations' => [
                        ['violation 1'],
                        ['violation 2'],
                        ['violation 3'],
                    ],
                    'compliances' => [
                        ['compliance 1'],
                        ['compliance 2'],
                    ],
                ],
                'violations' => [
                    $this->mockViolation(['violation 1']),
                    $this->mockViolation(['violation 2']),
                    $this->mockViolation(['violation 3']),
                ],
                'compliances' => [
                    $this->mockCompliance(['compliance 1']),
                    $this->mockCompliance(['compliance 2']),
                ],
            ],
        ];
    }
}