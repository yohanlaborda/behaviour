<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
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
            if ($annotation->hasError()) {
                $errors[] = sprintf('The file "%s" not exist.', $annotation->getFile());
            }
        }

        return $errors;
    }
}
