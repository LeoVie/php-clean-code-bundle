<?php

namespace LeoVie\PhpCleanCode\Calculator\CalculatorConcept;

interface AmountCalculator
{
    public function calculate(float $part, float $whole): float;
}