<?php

namespace LeoVie\PhpCleanCode\Tests\TestDouble\ThirdParty;

use LeoVie\PhpFilesystem\Model\Boundaries;
use LeoVie\PhpFilesystem\Service\Filesystem;

class FilesystemDouble implements Filesystem
{
    public array $files = [];

    public function fileExists(string $filepath): bool
    {
        return array_key_exists($filepath, $this->files);
    }

    public function readFile(string $filepath): string
    {
        return $this->files[$filepath];
    }

    public function readFilePart(string $filepath, Boundaries $boundaries): string
    {
        return $this->files[$filepath];
    }

    public function writeFile(string $filepath, string $content): int
    {
        $this->files[$filepath] = $content;

        return strlen($content);
    }
}