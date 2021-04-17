<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;

class WithoutAnnotationError implements ErrorInterface
{
    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope, BehaviourCollection $collection): array
    {
        $functionName = MethodNameFromNode::getName($node);
        $className = ClassNameFromScope::getName($scope);

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'The "%s" method of the "%s" class does not have the annotation @Behaviour',
                    $functionName,
                    $className
                )
            )->build()
        ];
    }
}
