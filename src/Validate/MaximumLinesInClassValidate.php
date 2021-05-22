<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\MaximumLinesInClassError;
use yohanlaborda\behaviour\Utility\LineNumberFromNode;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class MaximumLinesInClassValidate implements ValidateInterface, ErrorValidateInterface
{
    private int $maximumLinesInClass;

    public function __construct(int $maximumLinesInClass)
    {
        $this->maximumLinesInClass = $maximumLinesInClass;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        if (false === $node instanceof Class_) {
            return false;
        }

        if (LineNumberFromNode::isUndefinedLineNumber($node)) {
            return true;
        }

        $totalLines = $node->getEndLine() - $node->getStartLine();

        return $totalLines <= $this->maximumLinesInClass;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }

    public function getError(): ErrorInterface
    {
        return new MaximumLinesInClassError($this->maximumLinesInClass);
    }
}
