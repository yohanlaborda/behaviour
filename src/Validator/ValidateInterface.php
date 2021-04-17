<?php

namespace yohanlaborda\behaviour\Validator;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

interface ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool;

    public function finishAfterFail(): bool;
}
