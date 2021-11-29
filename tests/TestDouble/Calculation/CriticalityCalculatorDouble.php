<?php

namespace LeoVie\PhpCleanCode\Tests\TestDouble\Calculation;

use LeoVie\PhpCleanCode\Calculation\CalculatorConcept\CriticalityCalculator;

class CriticalityCalculatorDouble implements CriticalityCalculator
{
    public function calculate(float $actual, float $allowed, float $criticalityFactorInPercent): float
    {
        return 10.0;
    }
}