<?php

namespace yohanlaborda\behaviour\Validate\Condition;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\MaximumIfAllowedError;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class MaximumIfAllowedValidate implements ValidateInterface, ErrorValidateInterface
{
    private int $maximumIfAllowed;

    public function __construct(int $maximumIfAllowed)
    {
        $this->maximumIfAllowed = $maximumIfAllowed;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        if (false === $node instanceof ClassMethod) {
            return false;
        }

        $stmts = $node->getStmts();
        if (null === $stmts) {
            return true;
        }

        return $this->countIf($stmts) <= $this->maximumIfAllowed;
    }

    /**
     * @param Stmt[] $stmts
     */
    private function countIf(array $stmts): int
    {
        $count = 0;
        foreach ($stmts as $stmt) {
            $count += $this->countFromStmt($stmt);
        }

        return $count;
    }

    private function countFromStmt(Stmt $stmt): int
    {
        $count = $stmt instanceof If_ ? 1 : 0;

        $stmts = property_exists($stmt, 'stmts') ? $stmt->stmts : null;
        if ($stmts !== null && count($stmts) > 0) {
            $count += $this->countIf($stmts);
        }

        return $count;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }

    public function getError(): ErrorInterface
    {
        return new MaximumIfAllowedError($this->maximumIfAllowed);
    }
}
