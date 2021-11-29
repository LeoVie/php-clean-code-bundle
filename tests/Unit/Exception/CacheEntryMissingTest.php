<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Exception;

use LeoVie\PhpCleanCode\Exception\CacheEntryMissing;
use PHPUnit\Framework\TestCase;

class CacheEntryMissingTest extends TestCase
{
    public function testGetMessage(): void
    {
        $expected = 'Cache entry is missing for key "abcdefghijklmnopqrst".';

        self::assertSame($expected, CacheEntryMissing::create('abcdefghijklmnopqrstuvwxyz')->getMessage());
    }
}