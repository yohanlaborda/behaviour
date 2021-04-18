<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;

interface ErrorInterface
{
    /**
     * @return RuleError[]
     */
    public function create(Node $node, Scope $scope): array;
}
