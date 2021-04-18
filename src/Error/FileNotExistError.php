<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class FileNotExistError implements ErrorInterface
{
    private BehaviourCollection $collection;

    public function __construct(BehaviourCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope): array
    {
        $errors = [];
        $annotations = $this->collection->getAnnotations();
        foreach ($annotations as $annotation) {
            $errors[] = RuleErrorBuilder::message(
                sprintf('The file "%s" not exist.', $annotation->getFile())
            )->build();
        }

        return $errors;
    }
}
