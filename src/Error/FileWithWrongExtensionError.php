<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class FileWithWrongExtensionError implements ErrorInterface
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

    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope): array
    {
        $errors = [];
        $annotations = $this->collection->getAnnotations();
        foreach ($annotations as $annotation) {
            if ($annotation->hasError()) {
                $errors[] = sprintf(
                    'The file "%s" extension is not one of the following: %s.',
                    $annotation->getFile(),
                    implode(', ', $this->extensions)
                );
            }
        }

        return $errors;
    }
}
