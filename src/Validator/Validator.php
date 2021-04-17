<?php

namespace yohanlaborda\behaviour\Validator;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class Validator
{
    private Node $node;
    private Scope $scope;
    private BehaviourCollection $collection;

    /**
     * @var RuleError[]
     */
    private array $errors = [];

    public function __construct(Node $node, Scope $scope, BehaviourCollection $collection)
    {
        $this->node = $node;
        $this->scope = $scope;
        $this->collection = $collection;
    }

    /**
     * @param ValidateList $validateList
     * @return RuleError[]
     */
    public function execute(ValidateList $validateList): array
    {
        $this->errors = [];
        $this->validate($validateList);

        return $this->errors;
    }

    private function validate(ValidateList $validateList): void
    {
        if (false === $validateList->valid()) {
            return;
        }

        $validate = $validateList->current();
        $isValid = $validate->isValid($this->node, $this->scope);
        $isNotValid = false === $isValid;

        if ($isNotValid) {
            $this->addErrors($validate);
        }

        if ($isNotValid && $validate->finishAfterFail()) {
            return;
        }

        $validateList->next();
        $this->validate($validateList);
    }

    private function addErrors(ValidateInterface $validate): void
    {
        if (false === $validate instanceof ErrorValidateInterface) {
            return;
        }

        $error = $validate->getError();
        $errors = $error->create($this->node, $this->scope, $this->collection);
        $this->errors = array_merge($this->errors, $errors);
    }
}
