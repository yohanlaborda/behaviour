<?php

namespace yohanlaborda\behaviour\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\ErrorInterface;
use yohanlaborda\behaviour\Error\FileWithWrongExtension;
use yohanlaborda\behaviour\Validator\ErrorValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateInterface;

final class AnnotationFileExtensionsValidate implements ValidateInterface, ErrorValidateInterface
{
    private BehaviourCollection $collection;

    /**
     * @var string[]
     */
    private array $extensions;

    /**
     * @param string[] $extensions
     */
    public function __construct(BehaviourCollection $collection, array $extensions)
    {
        $this->collection = $collection;
        $this->extensions = $extensions;
    }

    public function isValid(Node $node, Scope $scope): bool
    {
        if ($this->collection->notHasAnnotations()) {
            return false;
        }

        $annotations = $this->collection->getAnnotations();
        foreach ($annotations as $annotation) {
            if ($this->fileNotHasAnExtension($annotation->getFile())) {
                return false;
            }
        }

        return true;
    }

    private function fileNotHasAnExtension(string $filePath): bool
    {
        return false === $this->fileHasAnExtension($filePath);
    }

    private function fileHasAnExtension(string $filePath): bool
    {
        foreach ($this->extensions as $extension) {
            if ($this->fileHasExtension($filePath, $extension)) {
                return true;
            }
        }

        return false;
    }

    private function fileHasExtension(string $filePath, string $extension): bool
    {
        $length = strlen($extension);
        $offset = 0 - $length;
        $extensionFound = substr($filePath, $offset, $length);

        return $extension === $extensionFound;
    }

    public function finishAfterFail(): bool
    {
        return false;
    }

    public function getError(): ErrorInterface
    {
        return new FileWithWrongExtension($this->collection, $this->extensions);
    }
}
