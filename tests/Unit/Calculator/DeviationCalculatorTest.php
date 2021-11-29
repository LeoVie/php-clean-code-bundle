<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Calculator;

use LeoVie\PhpCleanCode\Calculator\DeviationCalculator;
use LeoVie\PhpCleanCode\Tests\TestDouble\Calculation\AmountCalculatorDouble;
use PHPUnit\Framework\TestCase;

class DeviationCalculatorTest extends TestCase
{
    /** @dataProvider calculateAbsoluteDeviationProvider */
    public function testCalculateAbsoluteDeviation(float $expected, float $actual, float $allowed): void
    {
        self::assertSame(
            $expected,
            (new DeviationCalculator(new AmountCalculatorDouble(0.0)))->calculateAbsoluteDeviation($actual, $allowed)
        );
    }

    public function calculateAbsoluteDeviationProvider(): array
    {
        return [
            'actual > allowed' => [
                'expected' => 10.0,
                'actual' => 90.0,
                'allowed' => 80.0,
            ],
            'actual == allowed' => [
                'expected' => 0.0,
                'actual' => 90.0,
                'allowed' => 90.0,
            ],
            'actual < allowed' => [
                'expected' => 10.0,
                'actual' => 90.0,
                'allowed' => 100.0,
            ],
        ];
    }

    /** @dataProvider calculateRelativeDeviationProvider */
    public function testCalculateRelativeDeviation(float $expected, float $amount): void
    {
        self::assertSame(
            $expected,
            (new DeviationCalculator(new AmountCalculatorDouble($amount)))->calculateRelativeDeviation(0.0, 0.0)
        );
    }

    public function calculateRelativeDeviationProvider(): array
    {
        return [
            [
                'expected' => 11.0,
                'amount' => 10.9
            ],
            [
                'expected' => 11.0,
                'amount' => 10.5
            ],
            [
                'expected' => 11.0,
                'amount' => 10.4
            ],
            [
                'expected' => 10.0,
                'amount' => 10.0
            ],
        ];
    }
}