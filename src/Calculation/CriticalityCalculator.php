<?php

namespace LeoVie\PhpCleanCode\Calculation;

class CriticalityCalculator implements CalculatorConcept\CriticalityCalculator
{
    public function __construct(private DeviationCalculator $deviationCalculator)
    {
    }

    public function calculate(float $actual, float $allowed, float $criticalityFactorInPercent): float
    {
        $deviationInPercent = $this->deviationCalculator->calculateRelativeDeviation($actual, $allowed);

        return $deviationInPercent / 100 * $criticalityFactorInPercent;
    }
}