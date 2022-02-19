<?php

namespace LeoVie\PhpCleanCode\Rule;

use LeoVie\PhpCleanCode\Rule\RuleConcept\Rule;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleClassNodeAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleLinesAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleNameNodeAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleTokenSequenceAware;

/** @psalm-immutable */
class RuleCollection
{
    /** @var array<string, array<int, Rule>> */
    private array $rules = [];

    /** @param iterable<RuleClassNodeAware|RuleTokenSequenceAware|RuleNameNodeAware|RuleLinesAware> $rules */
    public function __construct(iterable $rules)
    {
        foreach ($rules as $rule) {
            /** @var string $ruleAwareOf */
            $ruleAwareOf = $rule::AWARE_OF;
            $this->rules[$ruleAwareOf][] = $rule;
        }
    }

    /** @return RuleClassNodeAware[] */
    public function getClassNodeAwareRules(): array
    {
        /** @var RuleClassNodeAware[] $rules */
        $rules = $this->rules[Rule::CLASS_NODE_AWARE] ?? [];

        return $rules;
    }

    /** @return RuleTokenSequenceAware[] */
    public function getTokenSequenceAwareRules(): array
    {
        /** @var RuleTokenSequenceAware[] $rules */
        $rules = $this->rules[Rule::TOKEN_SEQUENCE_AWARE] ?? [];

        return $rules;
    }

    /** @return RuleNameNodeAware[] */
    public function getNameNodeAwareRules(): array
    {
        /** @var RuleNameNodeAware[] $rules */
        $rules = $this->rules[Rule::NAME_NODE_AWARE] ?? [];

        return $rules;
    }

    /** @return RuleLinesAware[] */
    public function getLinesAwareRules(): array
    {
        /** @var RuleLinesAware[] $rules */
        $rules = $this->rules[Rule::LINES_AWARE] ?? [];

        return $rules;
    }
}