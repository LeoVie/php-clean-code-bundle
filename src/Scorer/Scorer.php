<?php

namespace LeoVie\PhpCleanCode\Scorer;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;

interface Scorer
{
    public function create(FileRuleResults $fileRuleResults): Score;
}