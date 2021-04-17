<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class NodeIsClassMethodValidate implements ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool
    {
        return $node instanceof ClassMethod;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}
