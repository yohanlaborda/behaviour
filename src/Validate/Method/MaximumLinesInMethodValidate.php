<?php

namespace yohanlaborda\behaviour\Validate\Method;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\MaximumLinesInMethodError;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class MaximumLinesInMethodValidate implements ValidateInterface, ErrorValidateInterface
{
    // The line with the name of the method plus the two keys, this may vary, but we will only count these three
    private const EXTRACT_LINES = 3;
    private const UNDEFINED_LINE_NUMBER = -1;
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

        if ($this->isUndefinedLineNumber($node)) {
            return true;
        }

        $differenceBetweenLines = $node->getEndLine() - $node->getStartLine();
        $totalLines = $differenceBetweenLines - self::EXTRACT_LINES;

        return $totalLines <= $this->maximumLinesInMethod;
    }

    private function isUndefinedLineNumber(Node $node): bool
    {
        if ($node->getStartLine() === self::UNDEFINED_LINE_NUMBER) {
            return true;
        }

        if ($node->getEndLine() === self::UNDEFINED_LINE_NUMBER) {
            return true;
        }

        return false;
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
