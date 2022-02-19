<?php

namespace LeoVie\PhpCleanCode\Calculator\CalculatorConcept;

/** @psalm-immutable */
interface DeviationCalculator
{
    public function calculateRelativeDeviation(float $actual, float $allowed): float;
    public function calculateAbsoluteDeviation(float $actual, float $allowed): float;
}