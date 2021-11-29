<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Cache;

use LeoVie\PhpCleanCode\Cache\NodeVisitorCollectionCache;
use LeoVie\PhpCleanCode\Exception\CacheEntryMissing;
use LeoVie\PhpCleanCode\Parse\NodeVisitor\NodeVisitorCollection;
use PHPUnit\Framework\TestCase;

class NodeVisitorCollectionCacheTest extends TestCase
{
    /** @dataProvider isCachedProvider */
    public function testIsCached(bool $expected, string $fileCode, NodeVisitorCollectionCache $nodeVisitorCollectionCache): void
    {
        self::assertSame($expected, $nodeVisitorCollectionCache->isCached($fileCode));
    }

    public function isCachedProvider(): array
    {
        $nodeVisitorCollection = $this->createMock(NodeVisitorCollection::class);

        return [
            'no items in cache' => [
                'expected' => false,
                'fileCode' => 'abc',
                'nodeVisitorCollectionCache' => new NodeVisitorCollectionCache(),
            ],
            'requested item not in cache' => [
                'expected' => false,
                'fileCode' => 'abc',
                'nodeVisitorCollectionCache' => (new NodeVisitorCollectionCache())->set('def', $nodeVisitorCollection),
            ],
            'requested item in cache' => [
                'expected' => true,
                'fileCode' => 'abc',
                'nodeVisitorCollectionCache' => (new NodeVisitorCollectionCache())->set('abc', $nodeVisitorCollection),
            ],
        ];
    }

    public function testGetThrows(): void
    {
        self::expectException(CacheEntryMissing::class);

        (new NodeVisitorCollectionCache())->get('abc');
    }

    public function testSetAndGet(): void
    {
        $nodeVisitorCollection = $this->createMock(NodeVisitorCollection::class);

        self::assertSame(
            $nodeVisitorCollection, (new NodeVisitorCollectionCache())->set('abc', $nodeVisitorCollection)->get('abc')
        );
    }
}