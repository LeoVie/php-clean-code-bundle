<?php

namespace LeoVie\PhpCleanCode\Calculator\CalculatorConcept;

interface DeviationCalculator
{
    public function calculateRelativeDeviation(float $actual, float $allowed): float;
    public function calculateAbsoluteDeviation(float $actual, float $allowed): float;
}