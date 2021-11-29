<?php

namespace LeoVie\PhpCleanCode\Tests\TestDouble\Calculation;

use LeoVie\PhpCleanCode\Calculation\CalculatorConcept\AmountCalculator;

class AmountCalculatorDouble implements AmountCalculator
{
    public function calculate(float $part, float $whole): float
    {
        return 50.0;
    }
}