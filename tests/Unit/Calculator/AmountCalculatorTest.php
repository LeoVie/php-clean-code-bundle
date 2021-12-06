<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Calculator;

use LeoVie\PhpCleanCode\Calculator\AmountCalculator;
use PHPUnit\Framework\TestCase;

class AmountCalculatorTest extends TestCase
{
    /** @dataProvider calculateProvider */
    public function testCalculate(float $expected, float $part, float $whole): void
    {
        self::assertSame($expected, (new AmountCalculator())->calculate($part, $whole));
    }

    public function calculateProvider(): array
    {
        return [
            [
                'expected' => 0.0,
                'part' => 0.0,
                'whole' => 200.0,
            ],
            [
                'expected' => 12.5,
                'part' => 25.0,
                'whole' => 200.0,
            ],
            [
                'expected' => 50.0,
                'part' => 100.0,
                'whole' => 200.0,
            ],
            [
                'expected' => 100.0,
                'part' => 200.0,
                'whole' => 200.0,
            ],
            [
                'expected' => INF,
                'part' => 200.0,
                'whole' => 0.0,
            ],
        ];
    }
}