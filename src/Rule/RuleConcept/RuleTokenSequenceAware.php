<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;
use LeoVie\PhpTokenNormalize\Model\TokenSequence;

interface RuleTokenSequenceAware extends Rule
{
    /** @var string */
    public const AWARE_OF = Rule::TOKEN_SEQUENCE_AWARE;

    /** @return RuleResult[] */
    public function check(TokenSequence $tokenSequence): array;
}