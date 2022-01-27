<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;
use PhpParser\Node\Stmt\Class_;

interface RuleClassNodeAware extends Rule
{
    /** @var string */
    public const AWARE_OF = Rule::CLASS_NODE_AWARE;

    /** @return RuleResult[] */
    public function check(Class_ $class): array;
}