<?php

namespace yohanlaborda\behaviour\Validator;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

final class Validator
{
    private Node $node;
    private Scope $scope;

    /**
     * @var string[]
     */
    private array $errors = [];

    public function __construct(Node $node, Scope $scope)
    {
        $this->node = $node;
        $this->scope = $scope;
    }

    /**
     * @param ValidateList $validateList
     * @return string[]
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

        $this->validateCurrent($validateList);
    }

    private function validateCurrent(ValidateList $validateList): void
    {
        $current = $validateList->current();
        if ($current->isValid($this->node, $this->scope)) {
            $this->validateNext($validateList);
            return;
        }

        $this->addErrors($current);
        if (false === $current->finishAfterFail()) {
            $this->validateNext($validateList);
        }
    }

    private function validateNext(ValidateList $validateList): void
    {
        $validateList->next();
        $this->validate($validateList);
    }

    private function addErrors(ValidateInterface $validate): void
    {
        if (false === $validate instanceof ErrorValidateInterface) {
            return;
        }

        $error = $validate->getError();
        $errors = $error->create($this->node, $this->scope);
        $this->errors = array_merge($this->errors, $errors);
    }
}
