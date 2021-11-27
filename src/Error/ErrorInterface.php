<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

interface ErrorInterface
{
    /**
     * @return string[]
     */
    public function create(Node $node, Scope $scope): array;
}
