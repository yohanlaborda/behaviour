<?php

namespace yohanlaborda\behaviour\Tests\Validator;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExistValidate;
use yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExtensionsValidate;
use yohanlaborda\behaviour\Validate\NodeIsPublicValidate;
use yohanlaborda\behaviour\Validator\ValidateList;
use yohanlaborda\behaviour\Validator\Validator;

/**
 * @covers \yohanlaborda\behaviour\Validator\Validator
 */
final class ValidatorTest extends TestCase
{
    private Validator $validator;

    /**
     * @var Node&ClassMethod&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    private BehaviourCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new BehaviourCollection();
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = 'execute';
        $this->scope = $this->createMock(Scope::class);
        $this->validator = new Validator($this->node, $this->scope);
    }

    public function testExecuteWithTwoError(): void
    {
        $this->collection->add(new Behaviour('service.error'));
        $validateList = new ValidateList([
            new AnnotationFileExistValidate($this->collection),
            new AnnotationFileExtensionsValidate($this->collection, ['feature', 'features'])

        ]);
        $errors = $this->validator->execute($validateList);

        self::assertCount(2, $errors);
    }

    public function testExecuteWithoutError(): void
    {
        $this->collection->add(new Behaviour('service.features'));
        $validateList = new ValidateList([
            new NodeIsPublicValidate(),
            new AnnotationFileExtensionsValidate($this->collection, ['feature', 'features'])
        ]);
        $errors = $this->validator->execute($validateList);

        self::assertCount(0, $errors);
    }
}
