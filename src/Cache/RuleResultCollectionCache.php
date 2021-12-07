<?php

namespace LeoVie\PhpCleanCode\Cache;

use LeoVie\PhpCleanCode\Exception\CacheEntryMissing;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpFilesystem\Service\Filesystem;

class RuleResultCollectionCache
{
    public const CACHE_FILE = __DIR__ . '/.rule_result_collection_cache';

    /** @var array<string, RuleResultCollection> */
    private array $cache = [];

    public function __construct(private Filesystem $filesystem)
    {
        if ($this->filesystem->fileExists(self::CACHE_FILE)) {
            /** @var array<string, RuleResultCollection> $cache */
            $cache = unserialize($this->filesystem->readFile(self::CACHE_FILE));
            $this->cache = $cache;
        }
    }

    public function isCached(string $fileCode): bool
    {
        return array_key_exists($fileCode, $this->cache);
    }

    public function get(string $fileCode): RuleResultCollection
    {
        if (!$this->isCached($fileCode)) {
            throw CacheEntryMissing::create($fileCode);
        }

        return $this->cache[$fileCode];
    }

    public function set(string $fileCode, RuleResultCollection $ruleResultCollection): self
    {
        $this->cache[$fileCode] = $ruleResultCollection;

        return $this;
    }

    public function save(): void
    {
        $this->filesystem->writeFile(self::CACHE_FILE, serialize($this->cache));
    }
}