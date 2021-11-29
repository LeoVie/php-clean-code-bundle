<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCN08MeaningfulClassnames;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\TestCase;

class CCN08MeaningfulClassnamesTest extends TestCase
{
    public function testGetName(): void
    {
        self::assertSame('CC-N-08 Meaningful Classnames', (new CCN08MeaningfulClassnames())->getName());
    }

    /** @dataProvider complianceProvider */
    public function testCompliance(Class_ $class, string $message): void
    {
        $rule = new CCN08MeaningfulClassnames();

        self::assertEquals(
            [Compliance::create($rule, $message)],
            $rule->check($class)
        );
    }

    public function complianceProvider(): array
    {
        return [
            [
                'node' => $this->mockClass('NotForbidden'),
                'message' => 'Classname "NotForbidden" is not forbidden.',
            ],
            [
                'node' => $this->mockClass('AlsoNotForbidden'),
                'message' => 'Classname "AlsoNotForbidden" is not forbidden.',
            ],
            [
                'node' => $this->mockClass(null),
                'message' => 'Class is anonymous and therefore not forbidden.',
            ],
        ];
    }

    private function mockClass(?string $name): Class_
    {
        $class = $this->createMock(Class_::class);

        if ($name !== null) {
            $name = $this->mockIdentifier($name);
        }

        $class->method('isAnonymous')->willReturn($name === null);

        $class->name = $name;

        return $class;
    }

    private function mockIdentifier(string $name): Identifier
    {
        $identifier = $this->createMock(Identifier::class);
        $identifier->name = $name;

        return $identifier;
    }

    /** @dataProvider violationProvider */
    public function testViolation(Class_ $class, string $message): void
    {
        $rule = new CCN08MeaningfulClassnames();

        self::assertEquals(
            [Violation::create($rule, $message, 50.0)],
            $rule->check($class)
        );
    }

    public function violationProvider(): array
    {
        return [
            [
                'node' => $this->mockClass('ForbiddenManager'),
                'message' => 'Classname "ForbiddenManager" matches forbidden pattern "@.*Manager$@".'
            ],
            [
                'node' => $this->mockClass('ForbiddenProcessor'),
                'message' => 'Classname "ForbiddenProcessor" matches forbidden pattern "@.*Processor$@".'
            ],
        ];
    }
}