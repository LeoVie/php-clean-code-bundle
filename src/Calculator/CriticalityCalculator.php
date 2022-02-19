<?php

namespace LeoVie\PhpCleanCode\Calculator;

/** @psalm-immutable */
class CriticalityCalculator implements CalculatorConcept\CriticalityCalculator
{
    public function __construct(private CalculatorConcept\DeviationCalculator $deviationCalculator)
    {
    }

    public function calculate(float $actual, float $allowed, float $criticalityFactorInPercent): float
    {
        $deviationInPercent = $this->deviationCalculator->calculateRelativeDeviation($actual, $allowed);

        return $deviationInPercent / 100 * $criticalityFactorInPercent;
    }
}