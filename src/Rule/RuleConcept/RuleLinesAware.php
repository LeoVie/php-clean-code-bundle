<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;

interface RuleLinesAware extends Rule
{
    /** @var string */
    public const AWARE_OF = Rule::LINES_AWARE;

    /**
     * @param array<int, string> $lines
     *
     * @return RuleResult[]
     */
    public function check(array $lines): array;
}