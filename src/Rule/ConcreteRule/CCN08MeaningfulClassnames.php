<?php

namespace LeoVie\PhpCleanCode\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\RuleConcept\RuleClassNodeAware;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;

class CCN08MeaningfulClassnames implements RuleClassNodeAware
{
    private const NAME = 'CC-N-08 Meaningful Classnames';
    private const VIOLATION_PATTERN = 'Classname "%s" matches forbidden pattern "%s".';
    private const ANONYMOUS_CLASS_PATTERN = 'Class is anonymous and therefore not forbidden.';
    private const COMPLIANCE_PATTERN = 'Classname "%s" is not forbidden.';
    private const FORBIDDEN_CLASSNAME_PATTERNS = [
        '@.*Manager$@',
        '@.*Processor$@',
    ];
    private const CRITICALITY_FACTOR = 50;

    /** @psalm-pure */
    public function getName(): string
    {
        return self::NAME;
    }

    private function getCriticalityFactor(): int
    {
        return self::CRITICALITY_FACTOR;
    }

    public function check(Class_ $class): array
    {
        if ($class->isAnonymous()) {
            return [Compliance::create($this, \Safe\sprintf(self::ANONYMOUS_CLASS_PATTERN))];
        }

        /** @var Identifier $classnameIdentifier */
        $classnameIdentifier = $class->name;
        $classname = $classnameIdentifier->name;

        $forbiddenNamePart = $this->getForbiddenNamePart($classname);
        if ($forbiddenNamePart !== null) {
            $message = \Safe\sprintf(
                self::VIOLATION_PATTERN,
                $classname,
                $forbiddenNamePart
            );
            $criticality = $this->getCriticalityFactor();

            return [Violation::create($this, $message, $criticality)];
        }

        $message = \Safe\sprintf(self::COMPLIANCE_PATTERN, $classname);

        return [Compliance::create($this, $message)];
    }

    private function getForbiddenNamePart(string $name): ?string
    {
        foreach (self::FORBIDDEN_CLASSNAME_PATTERNS as $pattern) {
            if (preg_match($pattern, $name)) {
                return $pattern;
            }
        }

        return null;
    }
}