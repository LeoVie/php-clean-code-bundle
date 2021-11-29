<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule\ConcreteRule;

use LeoVie\PhpCleanCode\Rule\ConcreteRule\CCF03InstanceVariablesGrouped;
use LeoVie\PhpCleanCode\Rule\RuleResult\Compliance;
use LeoVie\PhpCleanCode\Rule\RuleResult\Violation;
use LeoVie\PhpCleanCode\Tests\TestDouble\Calculation\CriticalityCalculatorDouble;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPUnit\Framework\TestCase;

class CCF03InstanceVariablesGroupedTest extends TestCase
{
    public function testGetName(): void
    {
        self::assertSame(
            'CC-F-03 Instance Variables Grouped',
            (new CCF03InstanceVariablesGrouped(new CriticalityCalculatorDouble()))->getName()
        );
    }

    /** @dataProvider complianceProvider */
    public function testCompliance(Class_ $class, string $message): void
    {
        $rule = new CCF03InstanceVariablesGrouped(new CriticalityCalculatorDouble());

        self::assertEquals(
            [Compliance::create($rule, $message)],
            $rule->check($class)
        );
    }

    public function complianceProvider(): array
    {
        $class = $this->mockClass(
            'Foo',
            [
                $this->createMock(ClassMethod::class),
                $this->createMock(Property::class),
                $this->createMock(Property::class),
                $this->createMock(ClassMethod::class),
            ]
        );

        return [
            [
                'class' => $class,
                'message' => 'Class "Foo" has no ungrouped instance variables.',
            ],
        ];
    }

    private function mockClass(string $name, array $statements): Class_
    {
        $class = $this->createMock(Class_::class);
        $class->name = $this->createMock(Identifier::class);
        $class->name->method('__toString')->willReturn($name);
        $class->stmts = $statements;

        return $class;
    }

    /** @dataProvider violationProvider */
    public function testViolation(Class_ $class, string $message): void
    {
        $rule = new CCF03InstanceVariablesGrouped(new CriticalityCalculatorDouble());

        self::assertEquals(
            [Violation::create($rule, $message, 10.0)],
            $rule->check($class)
        );
    }

    public function violationProvider(): array
    {
        $class = $this->mockClass(
            'Foo',
            [
                $this->createMock(ClassMethod::class),
                $this->createMock(Property::class),
                $this->createMock(ClassMethod::class),
                $this->createMock(Property::class),
                $this->createMock(Property::class),
                $this->createMock(ClassMethod::class),
                $this->createMock(Property::class),
            ]
        );

        return [
            [
                'class' => $class,
                'message' => 'Class "Foo" has ungrouped instance variables (3 groups).',
            ],
        ];
    }
}