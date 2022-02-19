<?php

namespace LeoVie\PhpCleanCode\Scorer\ConcreteScorers;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Scorer\Scorer;

/** @psalm-mutation-free */
class OnlyViolationsMatterScorer implements Scorer
{
    private const SCORE_TYPE = 'OnlyViolationsMatter';

    public function create(FileRuleResults $fileRuleResults): Score
    {
        if (count($fileRuleResults->getRuleResultCollection()->getViolations()) === 0) {
            return Score::create(self::SCORE_TYPE, 0);
        }

        $totalPoints = 0;
        foreach ($fileRuleResults->getRuleResultCollection()->getViolations() as $violation) {
            $totalPoints += $violation->getCriticality();
        }

        $totalPoints /= count($fileRuleResults->getRuleResultCollection()->getViolations());

        return Score::create(self::SCORE_TYPE, (int)$totalPoints);
    }
}