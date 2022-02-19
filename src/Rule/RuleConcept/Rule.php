<?php

namespace LeoVie\PhpCleanCode\Rule\RuleConcept;

interface Rule
{
    public const CLASS_NODE_AWARE = 'ClassNodeAware';
    public const TOKEN_SEQUENCE_AWARE = 'TokenSequenceAware';
    public const NAME_NODE_AWARE = 'NameNodeAware';
    public const LINES_AWARE = 'LinesAware';

    /** @psalm-pure */
    public function getName(): string;
}