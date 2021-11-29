<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Parse\NodeVisitor;

use LeoVie\PhpCleanCode\Parse\NodeVisitor\ExtractClassesNodeVisitor;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\TestCase;

class ExtractClassesNodeVisitorTest extends TestCase
{
    /** @dataProvider enterNodeProvider */
    public function testEnterNode(array $expected, array $nodes): void
    {
        $extractClassesNodeVisitor = new ExtractClassesNodeVisitor();
        foreach ($nodes as $node) {
            $extractClassesNodeVisitor->enterNode($node);
        }

        self::assertSame($expected, $extractClassesNodeVisitor->getClassNodes());
    }

    public function enterNodeProvider(): array
    {
        $nodes = [
            0 => $this->mockNode(),
            1 => $this->mockNode(),
            2 => $this->mockClass(),
            3 => $this->mockClass(),
            4 => $this->mockNode(),
            5 => $this->mockClass(),
        ];

        return [
            [
                'expected' => [
                    $nodes[2],
                    $nodes[3],
                    $nodes[5],
                ],
                'nodes' => $nodes,
            ]
        ];
    }

    public function testReset(): void
    {
        $extractClassesNodeVisitor = new ExtractClassesNodeVisitor();
        $extractClassesNodeVisitor->enterNode($this->mockClass());

        self::assertNotEmpty($extractClassesNodeVisitor->getClassNodes());
        self::assertEmpty($extractClassesNodeVisitor->reset()->getClassNodes());
    }

    private function mockNode(): Node
    {
        return $this->createMock(Node::class);
    }

    private function mockClass(): Class_
    {
        return $this->createMock(Class_::class);
    }
}