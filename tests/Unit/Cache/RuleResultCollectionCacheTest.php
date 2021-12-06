<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Cache;

use LeoVie\PhpCleanCode\Cache\RuleResultCollectionCache;
use LeoVie\PhpCleanCode\Exception\CacheEntryMissing;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpCleanCode\Tests\TestDouble\ThirdParty\FilesystemDouble;
use LeoVie\PhpFilesystem\Service\Filesystem;
use PHPUnit\Framework\TestCase;

class RuleResultCollectionCacheTest extends TestCase
{
    /** @dataProvider isCachedProvider */
    public function testIsCached(bool $expected, string $fileCode, RuleResultCollectionCache $ruleResultCollectionCache): void
    {
        self::assertSame($expected, $ruleResultCollectionCache->isCached($fileCode));
    }

    public function isCachedProvider(): array
    {
        $filesystem = new FilesystemDouble();

        $ruleResultCollection = $this->createMock(RuleResultCollection::class);

        return [
            'no items in cache' => [
                'expected' => false,
                'fileCode' => 'abc',
                'ruleResultCollectionCache' => new RuleResultCollectionCache($filesystem),
            ],
            'requested item not in cache' => [
                'expected' => false,
                'fileCode' => 'abc',
                'ruleResultCollectionCache' => (new RuleResultCollectionCache($filesystem))->set('def', $ruleResultCollection),
            ],
            'requested item in cache' => [
                'expected' => true,
                'fileCode' => 'abc',
                'ruleResultCollectionCache' => (new RuleResultCollectionCache($filesystem))->set('abc', $ruleResultCollection),
            ],
        ];
    }

    public function testGetThrows(): void
    {
        $filesystem = new FilesystemDouble();

        self::expectException(CacheEntryMissing::class);

        (new RuleResultCollectionCache($filesystem))->get('abc');
    }

    public function testSetAndGet(): void
    {
        $filesystem = new FilesystemDouble();

        $ruleResultCollection = $this->createMock(RuleResultCollection::class);

        self::assertSame(
            $ruleResultCollection, (new RuleResultCollectionCache($filesystem))->set('abc', $ruleResultCollection)->get('abc')
        );
    }

    public function testGetWhenRestoredFromFilesystem(): void
    {
        $ruleResultCollection = $this->createMock(RuleResultCollection::class);
        $filesystem = new FilesystemDouble();
        $filesystem->files = [
            RuleResultCollectionCache::CACHE_FILE => serialize(['abc' => $ruleResultCollection]),
        ];

        self::assertEquals(
            $ruleResultCollection, (new RuleResultCollectionCache($filesystem))->get('abc')
        );
    }

    public function testSetWritesToFilesystem(): void
    {
        $ruleResultCollection = $this->createMock(RuleResultCollection::class);
        $filesystem = new FilesystemDouble();

        (new RuleResultCollectionCache($filesystem))->set('abc', $ruleResultCollection);

        self::assertEquals(
            $ruleResultCollection, (new RuleResultCollectionCache($filesystem))->get('abc')
        );
    }
}