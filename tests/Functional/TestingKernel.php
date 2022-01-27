<?php
declare(strict_types=1);

namespace LeoVie\PhpCleanCode\Tests\Functional;

use LeoVie\PhpCleanCode\PhpCleanCodeBundle;
use LeoVie\PhpFilesystem\PhpFilesystemBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestingKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new PhpCleanCodeBundle(),
            new PhpFilesystemBundle()
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}