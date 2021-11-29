<?php

namespace LeoVie\PhpCleanCode\Calculation\CalculatorConcept;

interface CriticalityCalculator
{
    public function calculate(float $actual, float $allowed, float $criticalityFactorInPercent): float;
}