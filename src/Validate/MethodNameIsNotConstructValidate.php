<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class MethodNameIsNotConstructValidate implements ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool
    {
        $methodName = MethodNameFromNode::getName($node);

        return '__construct' !== $methodName;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}
