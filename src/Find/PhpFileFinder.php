<?php

namespace LeoVie\PhpCleanCode\Find;

use LeoVie\PhpCleanCode\ServiceFactory\FinderFactory;

class PhpFileFinder
{
    public function __construct(private FinderFactory $finderFactory)
    {
    }

    /** @return string[] */
    public function findPhpFilesInPath(string $path): array
    {
        return array_map(
            fn(\SplFileInfo $file) => $file->__toString(),
            iterator_to_array(
                $this->finderFactory->instance()->in($path)->name('*.php')->files()
            )
        );
    }
}