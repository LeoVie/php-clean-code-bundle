<?php

namespace LeoVie\PhpCleanCode\Calculation;

class AmountCalculator implements CalculatorConcept\AmountCalculator
{
    public function calculate(float $part, float $whole): float
    {
        return ($part / $whole) * 100;
    }
}