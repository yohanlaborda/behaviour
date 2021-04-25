<?php

namespace yohanlaborda\behaviour\Validate\Behaviour;

use Exception;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use ReflectionClass;
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
                $annotation->markWithError();
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

        $directoryName = $this->getDirectoryName($scope) ?? dirname($scope->getFile());
        $filePathFromClass = $directoryName . DIRECTORY_SEPARATOR . $filePath;

        return $this->isRealPath($filePathFromClass);
    }

    private function getDirectoryName(Scope $scope): ?string
    {
        $classReflection = $scope->getClassReflection();
        if (!$classReflection) {
            return null;
        }

        try {
            $reflectionClass = new ReflectionClass($classReflection->getName());
            $fileName = $reflectionClass->getFileName();
        } catch (Exception $exception) {
            return null;
        }

        return $fileName ? dirname($fileName) : null;
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
