<?php

namespace yohanlaborda\behaviour\Utility;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;

final class MethodNameFromNode
{
    /**
     * @param Node $node
     * @return string
     */
    public static function getName(Node $node): string
    {
        return $node instanceof ClassMethod ? $node->name->name : 'unknown';
    }
}