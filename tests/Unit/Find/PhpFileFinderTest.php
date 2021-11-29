<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Find;

use LeoVie\PhpCleanCode\Find\PhpFileFinder;
use LeoVie\PhpCleanCode\ServiceFactory\FinderFactory;
use PHPUnit\Framework\TestCase;

class PhpFileFinderTest extends TestCase
{
    public function testFindPhpFilesInPath(): void
    {
        $path = \Safe\realpath(__DIR__ . '/../../testdata/Find');

        $expected = [
            $path . '/nested/file_3.php',
            $path . '/file_1.php',
            $path . '/file_2.php',
        ];

        self::assertEqualsCanonicalizing($expected, (new PhpFileFinder(new FinderFactory()))->findPhpFilesInPath($path));
    }
}