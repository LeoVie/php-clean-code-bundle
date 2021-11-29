<?php

namespace LeoVie\PhpCleanCode\Rule\RuleResult;

use LeoVie\PhpCleanCode\Rule\RuleConcept\Rule;

class Compliance implements RuleResult
{
    private function __construct(private Rule $rule, private string $message)
    {
    }

    public static function create(Rule $rule, string $message): self
    {
        return new self($rule, $message);
    }

    public function getRule(): Rule
    {
        return $this->rule;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCriticality(): ?float
    {
        return null;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => 'compliance',
            'rule' => $this->rule->getName(),
            'message' => $this->message
        ];
    }
}