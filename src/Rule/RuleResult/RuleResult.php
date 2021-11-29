<?php

namespace LeoVie\PhpCleanCode\Rule\RuleResult;

use LeoVie\PhpCleanCode\Rule\RuleConcept\Rule;

interface RuleResult extends \JsonSerializable
{
    public function getRule(): Rule;

    public function getMessage(): string;

    public function getCriticality(): ?float;

    public function jsonSerialize(): array;
}