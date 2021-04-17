<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class NodeIsPublicValidate implements ValidateInterface
{
    public function isValid(Node $node, Scope $scope): bool
    {
        if ($node instanceof ClassMethod) {
            return true === $node->isPublic();
        }

        return false;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}
