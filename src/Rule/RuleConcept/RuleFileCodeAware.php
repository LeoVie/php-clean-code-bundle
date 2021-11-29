<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;

interface RuleFileCodeAware extends Rule
{
    public const AWARE_OF = Rule::FILE_CODE_AWARE;

    /** @return RuleResult[] */
    public function check(string $code): array;
}