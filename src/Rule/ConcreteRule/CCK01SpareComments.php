<?php

namespace LeoVie\PhpCleanCode\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Calculator\CalculatorConcept\AmountCalculator;
use LeoVie\PhpCleanCode\Calculator\CalculatorConcept\CriticalityCalculator;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleTokenSequenceAware;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpTokenNormalize\Model\TokenSequence;

class CCK01SpareComments implements RuleTokenSequenceAware
{
    private const NAME = 'CC-K-01 Spare Comments';
    private const VIOLATION_PATTERN
        = 'File has a too high amount of comment tokens (%f, that\' s %f percent points higher than allowed).';
    private const COMPLIANCE_PATTERN
        = 'File has an allowed amount of comment tokens (%f, that\'s %f percent points lower than allowed maximum).';
    private const MAX_AMOUNT_OF_COMMENT_TOKENS_IN_PERCENT = 5;
    private const CRITICALITY_FACTOR = 50;

    public function __construct(
        private CriticalityCalculator $criticalityCalculator,
        private AmountCalculator      $amountCalculator
    )
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    private function getMaxAmountOfCommentTokensInPercent(): int
    {
        return self::MAX_AMOUNT_OF_COMMENT_TOKENS_IN_PERCENT;
    }

    private function getCriticalityFactor(): int
    {
        return self::CRITICALITY_FACTOR;
    }

    public function check(TokenSequence $tokenSequence): array
    {
        $commentTokens = $tokenSequence->onlyComments()->filter();

        $amountOfComments = $this->amountCalculator->calculate($commentTokens->length(), $tokenSequence->length());

        if ($amountOfComments > $this->getMaxAmountOfCommentTokensInPercent()) {
            $criticality = $this->criticalityCalculator->calculate(
                $amountOfComments,
                $this->getMaxAmountOfCommentTokensInPercent(),
                $this->getCriticalityFactor()
            );

            $message = $this->buildMessage(self::VIOLATION_PATTERN, $amountOfComments);

            return [Violation::create($this, $message, $criticality)];
        }

        $message = $this->buildMessage(self::COMPLIANCE_PATTERN, $amountOfComments);

        return [Compliance::create($this, $message)];
    }

    private function buildMessage(string $pattern, float $amountOfComments): string
    {
        return \Safe\sprintf(
            $pattern,
            $amountOfComments,
            abs($amountOfComments - $this->getMaxAmountOfCommentTokensInPercent())
        );
    }
}