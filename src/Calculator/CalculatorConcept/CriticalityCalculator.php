<?php

namespace LeoVie\PhpCleanCode\Calculator\CalculatorConcept;

interface CriticalityCalculator
{
    public function calculate(float $actual, float $allowed, float $criticalityFactorInPercent): float;
}