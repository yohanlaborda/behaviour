<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;

final class MaximumLinesInMethodError implements ErrorInterface
{
    private int $maximumLinesInMethod;

    public function __construct(int $maximumLinesInMethod)
    {
        $this->maximumLinesInMethod = $maximumLinesInMethod;
    }

    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope): array
    {
        $functionName = MethodNameFromNode::getName($node);
        $className = ClassNameFromScope::getName($scope);

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'The "%s" method of the "%s" class has more than "%d" lines.',
                    $functionName,
                    $className,
                    $this->maximumLinesInMethod
                )
            )->build()
        ];
    }
}
