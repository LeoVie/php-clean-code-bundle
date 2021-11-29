<?php

namespace LeoVie\PhpCleanCode\Wrapper;

use PhpParser\Lexer;

class LineAndColumnLexerWrapper
{
    public function __construct(private Lexer $lexer)
    {
    }

    public function getLexer(): Lexer
    {
        return $this->lexer;
    }
}