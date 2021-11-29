<?php

namespace LeoVie\PhpCleanCode\Scorer\ConcreteScorers;

use LeoVie\PhpCleanCode\Model\Score;
use LeoVie\PhpCleanCode\Rule\FileRuleResults;
use LeoVie\PhpCleanCode\Scorer\Scorer;

class CompliancesAndViolationsMatterScorer implements Scorer
{
    private const SCORE_TYPE = 'CompliancesAndViolationsMatter';

    public function create(FileRuleResults $fileRuleResults): Score
    {
        $totalPoints = 0;
        foreach ($fileRuleResults->getRuleResultCollection()->getViolations() as $violation) {
            $totalPoints += $violation->getCriticality();
        }

        $totalPoints /= count($fileRuleResults->getRuleResultCollection()->getRuleResults());

        return Score::create(self::SCORE_TYPE, (int)$totalPoints);
    }
}