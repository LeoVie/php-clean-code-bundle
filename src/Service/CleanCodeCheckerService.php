<?php

namespace LeoVie\PhpCleanCode\Service;

use LeoVie\PhpCleanCode\Cache\RuleResultCollectionCache;
use LeoVie\PhpCleanCode\Find\PhpFileFinder;
use LeoVie\PhpCleanCode\Parse\ParseAndTraverser;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Rule\RuleCollection;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResult;
use LeoVie\PhpCleanCode\Rule\RuleResult\RuleResultCollection;
use LeoVie\PhpFilesystem\Service\Filesystem;
use LeoVie\PhpTokenNormalize\Model\TokenSequence;

class CleanCodeCheckerService
{
    public function __construct(
        private RuleCollection    $ruleCollection,
        private Filesystem        $filesystem,
        private PhpFileFinder     $phpFileFinder,
        private ParseAndTraverser $parseAndTraverser,
        private RuleResultCollectionCache $ruleResultCollectionCache
    )
    {
    }

    public function getRuleCollection(): RuleCollection
    {
        return $this->ruleCollection;
    }

    /** @return FileRuleResults[] */
    public function checkDirectory(string $path): array
    {
        $phpFiles = $this->phpFileFinder->findPhpFilesInPath($path);

        $fileRuleResults = array_map(
            fn(string $phpFile): FileRuleResults => $this->checkFile($phpFile),
            $phpFiles
        );

        $this->saveCache();

        return $fileRuleResults;
    }

    public function checkFile(string $path): FileRuleResults
    {
        $fileCode = $this->filesystem->readFile($path);

        return FileRuleResults::create($path, $this->checkCode($fileCode));
    }

    public function checkCode(string $fileCode): RuleResultCollection
    {
        if ($this->ruleResultCollectionCache->isCached($fileCode)) {
            return $this->ruleResultCollectionCache->get($fileCode);
        }

        $ruleResultCollection = RuleResultCollection::create(array_merge(
            $this->checkLinesAwareRules($fileCode),
            $this->checkTokenSequenceAwareRules($fileCode),
            $this->checkClassNodeAwareRules($fileCode),
            $this->checkNameNodeAwareRules($fileCode)
        ));

        $this->ruleResultCollectionCache->set($fileCode, $ruleResultCollection);

        return $ruleResultCollection;
    }

    /** @return RuleResult[] */
    public function checkLinesAwareRules(string $fileCode): array
    {
        $ruleResults = [];
        $lines = explode("\n", $fileCode);
        $lines = array_map(fn(string $line): string => rtrim($line), $lines);
        foreach ($this->ruleCollection->getLinesAwareRules() as $rule) {
            $ruleResults = array_merge(
                $ruleResults,
                $rule->check($lines)
            );
        }

        return $ruleResults;
    }

    /** @return RuleResult[] */
    public function checkTokenSequenceAwareRules(string $fileCode): array
    {
        $ruleResults = [];
        $tokenSequence = TokenSequence::create(\PhpToken::tokenize($fileCode));
        foreach ($this->ruleCollection->getTokenSequenceAwareRules() as $rule) {
            $ruleResults = array_merge(
                $ruleResults,
                $rule->check($tokenSequence)
            );
        }

        return $ruleResults;
    }

    /** @return RuleResult[] */
    public function checkClassNodeAwareRules(string $fileCode): array
    {
        $ruleResults = [];
        $classNodes = $this->parseAndTraverser
            ->parseAndTraverse($fileCode)
            ->getExtractClassesNodeVisitor()
            ->getClassNodes();
        foreach ($classNodes as $classNode) {
            foreach ($this->ruleCollection->getClassNodeAwareRules() as $rule) {
                $ruleResults = array_merge(
                    $ruleResults,
                    $rule->check($classNode)
                );
            }
        }

        return $ruleResults;
    }

    /** @return RuleResult[] */
    public function checkNameNodeAwareRules(string $fileCode): array
    {
        $ruleResults = [];
        $nameNodes = $this->parseAndTraverser
            ->parseAndTraverse($fileCode)
            ->getExtractNamesNodeVisitor()
            ->getNameNodes();
        foreach ($nameNodes as $nameNode) {
            foreach ($this->ruleCollection->getNameNodeAwareRules() as $rule) {
                $ruleResults = array_merge(
                    $ruleResults,
                    $rule->check($nameNode)
                );
            }
        }

        return $ruleResults;
    }

    public function saveCache(): self
    {
        $this->ruleResultCollectionCache->save();

        return $this;
    }
}