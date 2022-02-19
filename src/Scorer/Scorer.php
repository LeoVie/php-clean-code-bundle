<?php

namespace LeoVie\PhpCleanCode\Scorer;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;

/** @psalm-mutation-free */
interface Scorer
{
    public function create(FileRuleResults $fileRuleResults): Score;
}