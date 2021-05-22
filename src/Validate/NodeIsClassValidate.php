<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class NodeIsClassValidate implements ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool
    {
        return true === $node instanceof Class_;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}
