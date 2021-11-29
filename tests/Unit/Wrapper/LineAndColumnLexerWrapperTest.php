<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Wrapper;

use LeoVie\PhpCleanCode\Wrapper\LineAndColumnLexerWrapper;
use PhpParser\Lexer;
use PHPUnit\Framework\TestCase;

class LineAndColumnLexerWrapperTest extends TestCase
{
    public function testGetLexer(): void
    {
        $lexer = $this->createMock(Lexer::class);

        self::assertSame($lexer, (new LineAndColumnLexerWrapper($lexer))->getLexer());
    }
}