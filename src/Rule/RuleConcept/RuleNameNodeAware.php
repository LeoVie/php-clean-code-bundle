<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;

interface RuleNameNodeAware extends Rule
{
    /** @var string */
    public const AWARE_OF = Rule::NAME_NODE_AWARE;

    /** @return RuleResult[] */
    public function check(Identifier|Variable $node): array;
}