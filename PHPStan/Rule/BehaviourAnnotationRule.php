<?php

namespace yohanlaborda\PHPStan\Rule;

use Exception;
use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Reader\AnnotationReader;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;
use yohanlaborda\behaviour\Validate\AnnotationFileExistValidate;
use yohanlaborda\behaviour\Validate\AnnotationFileExtensionsValidate;
use yohanlaborda\behaviour\Validate\CollectionHasAnnotationValidate;
use yohanlaborda\behaviour\Validate\ExpressionApplyValidate;
use yohanlaborda\behaviour\Validate\MethodNameIsNotConstructValidate;
use yohanlaborda\behaviour\Validate\NodeIsClassMethodValidate;
use yohanlaborda\behaviour\Validate\NodeIsPublicValidate;
use yohanlaborda\behaviour\Validate\ScopeIsClassValidate;
use yohanlaborda\behaviour\Validator\ValidateList;
use yohanlaborda\behaviour\Validator\Validator;
use yohanlaborda\PHPStan\Configuration\BehaviourConfiguration;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
final class BehaviourAnnotationRule implements Rule
{
    private BehaviourConfiguration $configuration;

    public function __construct(BehaviourConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @inheritDoc
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $behaviourCollection = $this->getAnnotationsBehaviourOrNull($node, $scope);

        $validateList = new ValidateList([
            new ExpressionApplyValidate($this->configuration->getExpressions()),
            new ScopeIsClassValidate(),
            new NodeIsClassMethodValidate(),
            new NodeIsPublicValidate(),
            new MethodNameIsNotConstructValidate(),
            new CollectionHasAnnotationValidate($behaviourCollection),
            new AnnotationFileExistValidate($behaviourCollection),
            new AnnotationFileExtensionsValidate($behaviourCollection, $this->configuration->getExtensions())
        ]);

        $validator = new Validator($node, $scope, $behaviourCollection);

        return $validator->execute($validateList);
    }

    private function getAnnotationsBehaviourOrNull(Node $node, Scope $scope): BehaviourCollection
    {
        $className = ClassNameFromScope::getName($scope);
        $methodName = MethodNameFromNode::getName($node);
        $collectionEmpty = new BehaviourCollection();

        if (false === class_exists($className)) {
            return $collectionEmpty;
        }

        try {
            $behaviour = (new AnnotationReader())->getFromClassNameAndMethodName($className, $methodName);
        } catch (Exception $exception) {
            return $collectionEmpty;
        }

        return $behaviour ?? $collectionEmpty;
    }
}
