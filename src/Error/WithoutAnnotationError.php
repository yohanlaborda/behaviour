<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;

class WithoutAnnotationError implements ErrorInterface
{
    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope): array
    {
        $functionName = MethodNameFromNode::getName($node);
        $className = ClassNameFromScope::getName($scope);

        return [
            sprintf(
                'The "%s" method of the "%s" class does not have the annotation @Behaviour.',
                $functionName,
                $className
            )
        ];
    }
}
