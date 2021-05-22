<?php

namespace yohanlaborda\behaviour\Utility;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;

final class ClassNameFromNode
{
    public static function getName(Node $node): string
    {
        if ($node instanceof Class_ && $node->name) {
            return $node->name->name;
        }

        return 'unknown';
    }
}
