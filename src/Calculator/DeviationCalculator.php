<?php

namespace LeoVie\PhpCleanCode\Calculator;

/** @psalm-immutable */
class DeviationCalculator implements CalculatorConcept\DeviationCalculator
{
    public function __construct(private CalculatorConcept\AmountCalculator $amountCalculator)
    {
    }

    public function calculateRelativeDeviation(float $actual, float $allowed): float
    {
        return ceil($this->amountCalculator->calculate($this->calculateAbsoluteDeviation($actual, $allowed), $allowed));
    }

    /** @psalm-pure */
    public function calculateAbsoluteDeviation(float $actual, float $allowed): float
    {
        return abs($actual - $allowed);
    }
}