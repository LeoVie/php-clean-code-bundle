<?php

namespace LeoVie\PhpCleanCode\Tests\TestDouble\Calculation;

use LeoVie\PhpCleanCode\Calculator\CalculatorConcept\AmountCalculator;

class AmountCalculatorDouble implements AmountCalculator
{
    public function __construct(private float $amount)
    {
    }

    public function calculate(float $part, float $whole): float
    {
        return $this->amount;
    }
}