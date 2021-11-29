<?php

namespace LeoVie\PhpCleanCode\Tests\TestDouble\Calculation;

use LeoVie\PhpCleanCode\Calculator\CalculatorConcept\DeviationCalculator;

class DeviationCalculatorDouble implements DeviationCalculator
{
    public function __construct(
        private float $relativeDeviation,
        private float $absoluteDeviation
    )
    {
    }

    public function calculateRelativeDeviation(float $actual, float $allowed): float
    {
        return $this->relativeDeviation;
    }

    public function calculateAbsoluteDeviation(float $actual, float $allowed): float
    {
        return $this->absoluteDeviation;
    }
}