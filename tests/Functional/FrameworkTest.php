<?php

declare(strict_types=1);

namespace LeoVie\PhpCleanCode\Tests\Functional;

use LeoVie\PhpCleanCode\Service\CleanCodeCheckerService;
use LeoVie\PhpCleanCode\Service\CleanCodeScorerService;
use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase
{
    public function testServiceWiring(): void
    {
        $kernel = new TestingKernel('test', true);
        $kernel->boot();
        $cleanCodeCheckerService = $kernel->getContainer()->get(CleanCodeCheckerService::class);
        $cleanCodeScorerService = $kernel->getContainer()->get(CleanCodeScorerService::class);

        self::assertInstanceOf(CleanCodeCheckerService::class, $cleanCodeCheckerService);
        self::assertInstanceOf(CleanCodeScorerService::class, $cleanCodeScorerService);
    }
}