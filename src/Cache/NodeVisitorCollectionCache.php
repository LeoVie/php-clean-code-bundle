<?php

namespace LeoVie\PhpCleanCode\Cache;

use LeoVie\PhpCleanCode\Exception\CacheEntryMissing;
use LeoVie\PhpCleanCode\Parse\NodeVisitor\NodeVisitorCollection;

class NodeVisitorCollectionCache
{
    /** @var array<string, NodeVisitorCollection> */
    private array $parseCache = [];

    public function isCached(string $fileCode): bool
    {
        return array_key_exists($fileCode, $this->parseCache);
    }

    public function get(string $fileCode): NodeVisitorCollection
    {
        if (!$this->isCached($fileCode)) {
            throw CacheEntryMissing::create($fileCode);
        }

        return $this->parseCache[$fileCode];
    }

    public function set(string $fileCode, NodeVisitorCollection $nodeVisitorCollection): self
    {
        $this->parseCache[$fileCode] = $nodeVisitorCollection;

        return $this;
    }
}