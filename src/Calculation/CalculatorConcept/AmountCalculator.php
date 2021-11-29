<?php

namespace LeoVie\PhpCleanCode\Calculation\CalculatorConcept;

interface AmountCalculator
{
    public function calculate(float $part, float $whole): float;
}