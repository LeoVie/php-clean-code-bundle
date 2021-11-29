<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCF07ConsistentIndentationCharacters;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use PHPUnit\Framework\TestCase;

class CCF07ConsistentIndentationCharactersTest extends TestCase
{
    public function testGetName(): void
    {
        self::assertSame(
            'CC-F-07 Consistent Indentation Characters',
            (new CCF07ConsistentIndentationCharacters())->getName()
        );
    }

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
            'not indented' => [
                'lines' => ['not indented'],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32, 32, 32, 32) for indentation).',
            ],
            'empty line' => [
                'lines' => [''],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32, 32, 32, 32) for indentation).',
            ],
            'only whitespaces' => [
                'lines' => ['   ', '  '],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32, 32, 32, 32) for indentation).',
            ],
            'properly indented' => [
                'lines' => ['    properly indented'],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32, 32, 32, 32) for indentation).',
            ],
            'in block comment' => [
                'lines' => ['     * five spaces for indentation are okay here'],
                'message' => 'Code is properly indented (all lines use "    " (ascii 32, 32, 32, 32) for indentation).',
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
                    '   ',
                    '  not enough spaces',
                    '     too many spaces',
                    'not indented',
                    '	tab',
                ],
                'messages' => [
                    'Line 3 uses "  " (ascii 32, 32) for indentation, but should use "    " (ascii 32, 32, 32, 32).',
                    'Line 4 uses "     " (ascii 32, 32, 32, 32, 32) for indentation, but should use "    " (ascii 32, 32, 32, 32).',
                    'Line 6 uses "	" (ascii 9) for indentation, but should use "    " (ascii 32, 32, 32, 32).',
                ],
            ],
        ];
    }
}