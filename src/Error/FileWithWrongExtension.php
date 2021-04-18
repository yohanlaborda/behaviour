<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class FileWithWrongExtension implements ErrorInterface
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
            $errors[] = RuleErrorBuilder::message(
                sprintf(
                    'The file "%s" extension is not one of the following: %s.',
                    $annotation->getFile(),
                    implode(', ', $this->extensions)
                )
            )->build();
        }

        return $errors;
    }
}
