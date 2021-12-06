<?php

namespace LeoVie\PhpCleanCode\Calculator;

class AmountCalculator implements CalculatorConcept\AmountCalculator
{
    public function calculate(float $part, float $whole): float
    {
        if ($whole === 0.0) {
            return INF;
        }

        return ($part / $whole) * 100;
    }
}