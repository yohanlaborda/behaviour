<?php

namespace yohanlaborda\behaviour\Validate\Behaviour;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\WithoutAnnotationError;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class CollectionHasAnnotationValidate implements ValidateInterface, ErrorValidateInterface
{
    private BehaviourCollection $collection;

    public function __construct(BehaviourCollection $collection)
    {
        $this->collection = $collection;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        return $this->collection->hasAnnotations();
    }

    public function finishAfterFail(): bool
    {
        return true;
    }

    public function getError(): ErrorInterface
    {
        return new WithoutAnnotationError();
    }
}
