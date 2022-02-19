<?php

namespace LeoVie\PhpCleanCode\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Calculator\CalculatorConcept\CriticalityCalculator;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleLinesAware;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;

class CCF01VerticalSizeLimit implements RuleLinesAware
{
    private const NAME = 'CC-F-01 Vertical Size Limit';
    private const VIOLATION_PATTERN = 'File has %d lines more than allowed.';
    private const COMPLIANCE_PATTERN = 'File has %d lines.';
    private const CRITICALITY_FACTOR = 50;
    private const MAX_VERTICAL_SIZE = 500;

    public function __construct(private CriticalityCalculator $criticalityCalculator)
    {
    }

    /** @psalm-pure */
    public function getName(): string
    {
        return self::NAME;
    }

    private function getCriticalityFactor(): int
    {
        return self::CRITICALITY_FACTOR;
    }

    private function getMaxVerticalSize(): int
    {
        return self::MAX_VERTICAL_SIZE;
    }

    /** @inheritDoc */
    public function check(array $lines): array
    {
        $linesCount = count($lines);

        if ($linesCount > $this->getMaxVerticalSize()) {
            $message = $this->buildViolationMessage($linesCount);

            $criticality = $this->criticalityCalculator->calculate(
                $linesCount,
                $this->getMaxVerticalSize(),
                $this->getCriticalityFactor()
            );

            return [Violation::create($this, $message, $criticality)];
        }

        $message = $this->buildComplianceMessage($linesCount);

        return [Compliance::create($this, $message)];
    }

    private function buildViolationMessage(int $linesCount): string
    {
        return \Safe\sprintf(self::VIOLATION_PATTERN, $linesCount - $this->getMaxVerticalSize());
    }

    private function buildComplianceMessage(int $linesCount): string
    {
        return \Safe\sprintf(self::COMPLIANCE_PATTERN, $linesCount);
    }
}