<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCF07ConsistentIndentationCharacters;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use PHPUnit\Framework\TestCase;

class CCF07ConsistentIndentationCharactersTest extends TestCase
{
    /** @dataProvider complianceProvider */
    public function testCompliance(array $lines, string $message): void
    {
        $rule = new CCF07ConsistentIndentationCharacters();

        self::assertEquals(
            [Compliance::create($rule, $message)],
            $rule->check($lines)
        );
    }

    public function complianceProvider(): array
    {
        return [
            'properly indented' => [
                'lines' => ['    properly indented'],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32 (4 times)) for indentation).',
            ],
            'in block comment' => [
                'lines' => ['     * five spaces for indentation are okay here'],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32 (4 times)) for indentation).',
            ],
        ];
    }

    /** @dataProvider violationProvider */
    public function testViolation(array $lines, array $messages): void
    {
        $rule = new CCF07ConsistentIndentationCharacters();

        $violations = array_map(
            fn(string $message): Violation => Violation::create($rule, $message, 5.0),
            $messages
        );

        self::assertEquals(
            $violations,
            $rule->check($lines)
        );
    }

    public function violationProvider(): array
    {
        return [
            [
                'lines' => [
                    '     * five spaces for indentation are okay here',
                    '  not enough spaces',
                    '     too many spaces',
                    'not indented',
                    '	tab',
                ],
                'messages' => [
                    'Line 2 uses "  " (ascii 32 (2 times)) for indentation, but should use "    " (ascii 32 (4 times)).',
                    'Line 3 uses "     " (ascii 32 (5 times)) for indentation, but should use "    " (ascii 32 (4 times)).',
                    'Line 5 uses "	" (ascii 9 (1 times)) for indentation, but should use "    " (ascii 32 (4 times)).',
                ],
            ],
        ];
    }
}