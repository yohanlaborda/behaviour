<?php

namespace yohanlaborda\behaviour\Utility;

use PhpParser\Node;

final class LineNumberFromNode
{
    private const UNDEFINED_LINE_NUMBER = -1;

    public static function isUndefinedLineNumber(Node $node): bool
    {
        if ($node->getStartLine() === self::UNDEFINED_LINE_NUMBER) {
            return true;
        }

        if ($node->getEndLine() === self::UNDEFINED_LINE_NUMBER) {
            return true;
        }

        return false;
    }
}
