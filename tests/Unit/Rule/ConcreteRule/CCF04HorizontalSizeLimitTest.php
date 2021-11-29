<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCF04HorizontalSizeLimit;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpCleanCode\Tests\TestDouble\Calculation\CriticalityCalculatorDouble;
use PHPUnit\Framework\TestCase;

class CCF04HorizontalSizeLimitTest extends TestCase
{
    public function testGetName(): void
    {
        self::assertSame(
            'CC-F-04 Horizontal Size Limit',
            (new CCF04HorizontalSizeLimit(new CriticalityCalculatorDouble()))->getName()
        );
    }

    /** @dataProvider complianceProvider */
    public function testCompliance(array $lines, string $message): void
    {
        $rule = new CCF04HorizontalSizeLimit(new CriticalityCalculatorDouble());

        self::assertEquals(
            [Compliance::create($rule, $message)],
            $rule->check($lines)
        );
    }

    public function complianceProvider(): array
    {
        return [
            [
                'lines' => [
                    'this is not too long',
                    'and this neither',
                ],
                'message' => 'No too long lines exist in code.',
            ],
        ];
    }

    /** @dataProvider violationProvider */
    public function testViolation(array $lines, array $messages): void
    {
        $rule = new CCF04HorizontalSizeLimit(new CriticalityCalculatorDouble());

        $expected = [];
        foreach ($messages as $message) {
            $expected[] = Violation::create($rule, $message, 10.0);
        }

        self::assertEquals($expected, $rule->check($lines));
    }

    public function violationProvider(): array
    {
        return [
            [
                'lines' => [
                    'line with 130 chars---------------------------------------------------------------------------------------------------------------',
                    'line with 120 chars-----------------------------------------------------------------------------------------------------',
                    'line with 121 chars------------------------------------------------------------------------------------------------------',
                ],
                'messages' => [
                    'Line 1 has 10 characters more than allowed.',
                    'Line 3 has 1 characters more than allowed.',
                ],
            ],
        ];
    }
}