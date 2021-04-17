<?php

namespace yohanlaborda\behaviour\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class FileWithWrongExtension implements ErrorInterface
{
    /**
     * @var string[]
     */
    private array $extensions;

    /**
     * @param string[] $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * @inheritDoc
     */
    public function create(Node $node, Scope $scope, BehaviourCollection $collection): array
    {
        $errors = [];
        $annotations = $collection->getAnnotations();
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
