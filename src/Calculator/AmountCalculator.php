<?php

namespace LeoVie\PhpCleanCode\Calculator;

/** @psalm-immutable */
class AmountCalculator implements CalculatorConcept\AmountCalculator
{
    /** @psalm-pure */
    public function calculate(float $part, float $whole): float
    {
        if ($whole === 0.0) {
            return INF;
        }

        return ($part / $whole) * 100;
    }
}