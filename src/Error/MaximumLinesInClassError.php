<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Utility\ClassNameFromNode;

final class MaximumLinesInClassError implements ErrorInterface
{
    private int $maximumLinesInClass;

    public function __construct(int $maximumLinesInClass)
    {
        $this->maximumLinesInClass = $maximumLinesInClass;
    }

    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope): array
    {
        $namespace = $scope->getNamespace();
        $className = $namespace.'\\'.ClassNameFromNode::getName($node);

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'The "%s" class has more than "%d" lines.',
                    $className,
                    $this->maximumLinesInClass
                )
            )->build()
        ];
    }
}
