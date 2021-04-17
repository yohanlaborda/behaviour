<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class ExpressionApplyValidate implements ValidateInterface
{
    /**
     * @var string[]
     */
    private array $expressions;

    /**
     * @param string[] $expressions
     */
    public function __construct(array $expressions)
    {
        $this->expressions = $expressions;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        $className = ClassNameFromScope::getName($scope);

        foreach ($this->expressions as $expression) {
            if (preg_match($expression, $className)) {
                return true;
            }
        }

        return false;
    }

    public function finishAfterFail(): bool
    {
        return true;
    }
}
