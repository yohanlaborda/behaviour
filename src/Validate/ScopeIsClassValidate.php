<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class ScopeIsClassValidate implements ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool
    {
        return true === $scope->isInClass();
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}