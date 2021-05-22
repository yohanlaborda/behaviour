<?php

namespace yohanlaborda\PHPStan\Rule;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use yohanlaborda\behaviour\Validate\MaximumLinesInClassValidate;
use yohanlaborda\behaviour\Validate\NodeIsClassValidate;
use yohanlaborda\behaviour\Validator\ValidateList;
use yohanlaborda\behaviour\Validator\Validator;
use yohanlaborda\PHPStan\Configuration\LargeClassConfiguration;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\ClassLike>
 */
final class LargeClassRule implements Rule
{
    private LargeClassConfiguration $configuration;

    public function __construct(LargeClassConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    /**
     * @inheritDoc
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $validateList = new ValidateList([
            new NodeIsClassValidate(),
            new MaximumLinesInClassValidate($this->configuration->getMaximumLinesInClass())
        ]);

        $validator = new Validator($node, $scope);

        return $validator->execute($validateList);
    }
}
