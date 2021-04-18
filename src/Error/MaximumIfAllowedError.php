<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;

final class MaximumIfAllowedError implements ErrorInterface
{
    private int $maximumIfAllowed;

    public function __construct(int $maximumIfAllowed)
    {
        $this->maximumIfAllowed = $maximumIfAllowed;
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
                    'The "%s" method of the "%s" class has more than "%d" if conditions',
                    $functionName,
                    $className,
                    $this->maximumIfAllowed
                )
            )->build()
        ];
    }
}
