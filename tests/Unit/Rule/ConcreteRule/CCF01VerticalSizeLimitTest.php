<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCF01VerticalSizeLimit;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpCleanCode\Tests\TestDouble\Calculation\CriticalityCalculatorDouble;
use PHPUnit\Framework\TestCase;

class CCF01VerticalSizeLimitTest extends TestCase
{
    public function testGetName(): void
    {
        $rule = new CCF01VerticalSizeLimit(new CriticalityCalculatorDouble());

        self::assertSame('CC-F-01 Vertical Size Limit', $rule->getName());
    }

    /** @dataProvider complianceProvider */
    public function testCompliance(array $lines, string $message): void
    {
        $rule = new CCF01VerticalSizeLimit(new CriticalityCalculatorDouble());

        self::assertEquals(
            [Compliance::create($rule, $message)],
            $rule->check($lines)
        );
    }

    public function complianceProvider(): array
    {
        return [
            [
                'lines' => ['line'],
                'message' => 'File has 1 lines.',
            ],
            [
                'lines' => array_fill(0, 500, 'line'),
                'message' => 'File has 500 lines.',
            ],
        ];
    }

    /** @dataProvider violationProvider */
    public function testViolation(array $lines, string $message): void
    {
        $rule = new CCF01VerticalSizeLimit(new CriticalityCalculatorDouble());

        self::assertEquals(
            [Violation::create($rule, $message, 10.0)],
            $rule->check($lines)
        );
    }

    public function violationProvider(): array
    {
        return [
            [
                'lines' => array_fill(0, 501, 'line'),
                'message' => 'File has 1 lines more than allowed.',
            ],
        ];
    }
}