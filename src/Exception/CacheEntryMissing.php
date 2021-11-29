<?php

namespace LeoVie\PhpCleanCode\Exception;

class CacheEntryMissing extends \Exception
{
    public function __construct(string $key)
    {
        $message = \Safe\sprintf('Cache entry is missing for key "%s".', substr($key, 0, 20));

        parent::__construct($message);
    }

    public static function create(string $key): self
    {
        return new self($key);
    }
}