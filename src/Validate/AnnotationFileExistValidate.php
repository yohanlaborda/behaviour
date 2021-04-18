<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\FileNotExistError;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class AnnotationFileExistValidate implements ValidateInterface, ErrorValidateInterface
{
    private BehaviourCollection $collection;

    public function __construct(BehaviourCollection $collection)
    {
        $this->collection = $collection;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        if ($this->collection->notHasAnnotations()) {
            return false;
        }

        $annotations = $this->collection->getAnnotations();
        foreach ($annotations as $annotation) {
            if ($this->fileNotExist($scope, $annotation->getFile())) {
                return false;
            }
        }

        return true;
    }

    private function fileNotExist(Scope $scope, string $filePath): bool
    {
        return false === $this->fileExists($scope, $filePath);
    }

    private function fileExists(Scope $scope, string $filePath): bool
    {
        if ($this->isRealPath($filePath)) {
            return true;
        }

        $directoryClass = dirname($scope->getFile());
        $filePathFromClass = $directoryClass . DIRECTORY_SEPARATOR . $filePath;

        return $this->isRealPath($filePathFromClass);
    }

    private function isRealPath(string $filePath): bool
    {
        return false !== realpath($filePath);
    }

    public function finishAfterFail(): bool
    {
        return false;
    }

    public function getError(): ErrorInterface
    {
        return new FileNotExistError($this->collection);
    }
}
