<?php

namespace LeoVie\PhpCleanCode\Parse;

use LeoVie\PhpCleanCode\Cache\NodeVisitorCollectionCache;
use LeoVie\PhpCleanCode\Parse\NodeVisitor\NodeVisitorCollection;
use LeoVie\PhpCleanCode\Wrapper\LineAndColumnLexerWrapper;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use PhpParser\ParserFactory;

class ParseAndTraverser
{
    private Parser $parser;

    public function __construct(
        private NodeTraverser              $nodeTraverser,
        private NodeVisitorCollection      $nodeVisitorCollection,
        private NodeVisitorCollectionCache $nodeVisitorCollectionCache,
        LineAndColumnLexerWrapper          $lineAndColumnLexerWrapper,
        ParserFactory                      $parserFactory,
    )
    {
        $this->parser = $parserFactory->create(
            ParserFactory::PREFER_PHP7,
            $lineAndColumnLexerWrapper->getLexer()
        );
    }

    public function parseAndTraverse(string $fileCode): NodeVisitorCollection
    {
        if ($this->nodeVisitorCollectionCache->isCached($fileCode)) {
            return $this->nodeVisitorCollectionCache->get($fileCode);
        }

        /** @var Node[] $ast */
        $ast = $this->parser->parse($fileCode);

        $this->nodeVisitorCollection->resetAll();

        $this->nodeTraverser->addVisitor($this->nodeVisitorCollection->getExtractClassesNodeVisitor());
        $this->nodeTraverser->addVisitor($this->nodeVisitorCollection->getExtractNamesNodeVisitor());

        $this->nodeTraverser->traverse($ast);

        $this->nodeVisitorCollectionCache->set($fileCode, $this->nodeVisitorCollection);

        return $this->nodeVisitorCollection;
    }
}