<?php

namespace yohanlaborda\PHPStan\Rule;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use yohanlaborda\behaviour\Validate\Method\MaximumLinesInMethodValidate;
use yohanlaborda\behaviour\Validate\NodeIsClassMethodValidate;
use yohanlaborda\behaviour\Validate\ScopeIsClassValidate;
use yohanlaborda\behaviour\Validator\ValidateList;
use yohanlaborda\behaviour\Validator\Validator;
use yohanlaborda\PHPStan\Configuration\LongMethodConfiguration;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\FunctionLike>
 */
final class LongMethodRule implements Rule
{
    private LongMethodConfiguration $configuration;

    public function __construct(LongMethodConfiguration $configuration)
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
        $validateList = new ValidateList([
            new ScopeIsClassValidate(),
            new NodeIsClassMethodValidate(),
            new MaximumLinesInMethodValidate($this->configuration->getMaximumLinesInMethod())
        ]);

        $validator = new Validator($node, $scope);

        return $validator->execute($validateList);
    }
}
