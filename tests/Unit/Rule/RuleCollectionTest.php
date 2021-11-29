<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule;

use LeoVie\PhpCleanCode\Rule\RuleCollection;
use LeoVie\PhpCleanCode\Rule\RuleConcept\Rule;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleClassNodeAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleFileCodeAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleNameNodeAware;
use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleTokenSequenceAware;
use PHPUnit\Framework\TestCase;

class RuleCollectionTest extends TestCase
{
    public function testGetClassNodeAwareRules(): void
    {
        $rules = [
            $this->mockRule(Rule::CLASS_NODE_AWARE),
            $this->mockRule(Rule::FILE_CODE_AWARE),
            $this->mockRule(Rule::CLASS_NODE_AWARE),
        ];

        self::assertSame(
            [$rules[0], $rules[2]],
            (new RuleCollection(new \ArrayIterator($rules)))->getClassNodeAwareRules()
        );
    }

    public function testGetCodeAwareRules(): void
    {
        $rules = [
            $this->mockRule(Rule::FILE_CODE_AWARE),
            $this->mockRule(Rule::CLASS_NODE_AWARE),
            $this->mockRule(Rule::FILE_CODE_AWARE),
        ];

        self::assertSame(
            [$rules[0], $rules[2]],
            (new RuleCollection(new \ArrayIterator($rules)))->getFileCodeAwareRules()
        );
    }

    public function testGetTokenSequenceAwareRules(): void
    {
        $rules = [
            $this->mockRule(Rule::TOKEN_SEQUENCE_AWARE),
            $this->mockRule(Rule::CLASS_NODE_AWARE),
            $this->mockRule(Rule::TOKEN_SEQUENCE_AWARE),
        ];

        self::assertSame(
            [$rules[0], $rules[2]],
            (new RuleCollection(new \ArrayIterator($rules)))->getTokenSequenceAwareRules()
        );
    }

    public function testGetNameNodeAwareRules(): void
    {
        $rules = [
            $this->mockRule(Rule::NAME_NODE_AWARE),
            $this->mockRule(Rule::CLASS_NODE_AWARE),
            $this->mockRule(Rule::NAME_NODE_AWARE),
        ];

        self::assertSame(
            [$rules[0], $rules[2]],
            (new RuleCollection(new \ArrayIterator($rules)))->getNameNodeAwareRules()
        );
    }

    private function mockRule(string $awareOf): RuleClassNodeAware|RuleFileCodeAware|RuleTokenSequenceAware|RuleNameNodeAware
    {
        return match ($awareOf) {
            Rule::CLASS_NODE_AWARE => $this->createMock(RuleClassNodeAware::class),
            Rule::FILE_CODE_AWARE => $this->createMock(RuleFileCodeAware::class),
            Rule::TOKEN_SEQUENCE_AWARE => $this->createMock(RuleTokenSequenceAware::class),
            Rule::NAME_NODE_AWARE => $this->createMock(RuleNameNodeAware::class),
            default => throw new \Exception('Unsupported awareOf type')
        };
    }
}