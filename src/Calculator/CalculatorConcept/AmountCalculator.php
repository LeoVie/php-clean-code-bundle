<?php

namespace LeoVie\PhpCleanCode\Calculator\CalculatorConcept;

/** @psalm-immutable */
interface AmountCalculator
{
    public function calculate(float $part, float $whole): float;
}