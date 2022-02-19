<?php

namespace LeoVie\PhpCleanCode\Service;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Model\ScoresResult;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Scorer\Scorer;
use LeoVie\PhpCleanCode\Scorer\ScorerHolder;

class CleanCodeScorerService
{
    public function __construct(private ScorerHolder $scorerHolder)
    {
    }

    public function createScoresResult(FileRuleResults $fileRuleResults): ScoresResult
    {
        $scores = $this->createScores($fileRuleResults);

        return ScoresResult::create($fileRuleResults, $scores);
    }

    /** @return Score[] */
    public function createScores(FileRuleResults $fileRuleResults): array
    {
        return array_map(
            fn(Scorer $scorer): Score => $scorer->create($fileRuleResults),
            iterator_to_array($this->scorerHolder->getScorers())
        );
    }
}