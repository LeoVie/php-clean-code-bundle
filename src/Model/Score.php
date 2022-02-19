<?php

namespace LeoVie\PhpCleanCode\Model;

/** @psalm-immutable */
class Score implements \JsonSerializable
{
    /** @psalm-pure */
    private function __construct(
        private string $scoreType,
        private int    $points,
    )
    {
    }

    /** @psalm-pure */
    public static function create(string $scoreType, int $points): self
    {
        return new self($scoreType, $points);
    }

    public function getScoreType(): string
    {
        return $this->scoreType;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function jsonSerialize(): array
    {
        return [
            'score_type' => $this->scoreType,
            'points' => $this->points,
        ];
    }
}