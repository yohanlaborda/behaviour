<?php

namespace yohanlaborda\behaviour\Validate\Method;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\MaximumLinesInMethodError;
use yohanlaborda\behaviour\Utility\CountStmts;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class MaximumLinesInMethodValidate implements ValidateInterface, ErrorValidateInterface
{
    private int $maximumLinesInMethod;

    public function __construct(int $maximumLinesInMethod)
    {
        $this->maximumLinesInMethod = $maximumLinesInMethod;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        if (false === $node instanceof ClassMethod) {
            return false;
        }

        if (null === $node->stmts) {
            return true;
        }

        $count = (new CountStmts($node->stmts))->count();

        return $count <= $this->maximumLinesInMethod;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }

    public function getError(): ErrorInterface
    {
        return new MaximumLinesInMethodError($this->maximumLinesInMethod);
    }
}
