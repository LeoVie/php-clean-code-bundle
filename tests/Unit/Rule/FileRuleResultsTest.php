<?php

namespace LeoVie\PhpCleanCode\Tests\Unit\Rule;

use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use PHPUnit\Framework\TestCase;

class FileRuleResultsTest extends TestCase
{
    public function testGetPath(): void
    {
        $path = '/var/file.php';

        self::assertSame($path, FileRuleResults::create($path, RuleResultCollection::create([]))->getPath());
    }

    public function testGetRuleResultCollection(): void
    {
        $ruleResultCollection = $this->mockRuleResultCollection();

        self::assertSame($ruleResultCollection, FileRuleResults::create('', $ruleResultCollection)->getRuleResultCollection());
    }

    private function mockRuleResultCollection(array $jsonSerialized = []): RuleResultCollection
    {
        $ruleResultCollection = $this->createMock(RuleResultCollection::class);
        $ruleResultCollection->method('jsonSerialize')->willReturn($jsonSerialized);

        return $ruleResultCollection;
    }

    /** @dataProvider jsonSerializeProvider */
    public function testJsonSerialize(array $expected, string $path, RuleResultCollection $ruleResultCollection): void
    {
        self::assertSame($expected, FileRuleResults::create($path, $ruleResultCollection)->jsonSerialize());
    }

    public function jsonSerializeProvider(): array
    {
        $path = '/var/www/Foo.php';
        $ruleResultsSerialized = ['rule results'];
        $ruleResultCollection = $this->mockRuleResultCollection($ruleResultsSerialized);

        return [
            [
                'expected' => [
                    'path' => $path,
                    'rule_results' => $ruleResultsSerialized,
                ],
                'path' => $path,
                'ruleResultCollection' => $ruleResultCollection,
            ],
        ];
    }
}