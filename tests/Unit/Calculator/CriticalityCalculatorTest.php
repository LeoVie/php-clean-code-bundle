<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Calculator;

use LeoVie\PhpCleanCode\Calculator\CriticalityCalculator;
use LeoVie\PhpCleanCode\Tests\TestDouble\Calculation\DeviationCalculatorDouble;
use PHPUnit\Framework\TestCase;

class CriticalityCalculatorTest extends TestCase
{
    /** @dataProvider calculateProvider */
    public function testCalculate(float $expected, float $deviationInPercent, float $criticalityFactorInPercent): void
    {
        $deviationCalculator = new DeviationCalculatorDouble($deviationInPercent, 0.0);

        self::assertSame(
            $expected,
            (new CriticalityCalculator($deviationCalculator))->calculate(0.0, 0.0, $criticalityFactorInPercent)
        );
    }

    public function calculateProvider(): array
    {
        return [
            [
                'expected' => 10.0,
                'deviationInPercent' => 100.0,
                'criticalityFactorInPercent' => 10.0,
            ],
            [
                'expected' => 5.0,
                'deviationInPercent' => 50.0,
                'criticalityFactorInPercent' => 10.0,
            ],
        ];
    }
}