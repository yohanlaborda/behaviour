<?php

namespace yohanlaborda\behaviour\Tests\Validate\Behaviour;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\WithoutAnnotationError;
use yohanlaborda\behaviour\Validate\Behaviour\CollectionHasAnnotationValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\Behaviour\CollectionHasAnnotationValidate
 */
final class CollectionHasAnnotationValidateTest extends TestCase
{
    private CollectionHasAnnotationValidate $collectionHasAnnotationValidate;

    /**
     * @var Node&MockObject
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
        $this->collectionHasAnnotationValidate = new CollectionHasAnnotationValidate($this->collection);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithoutAnnotation(): void
    {
        $isValid = $this->collectionHasAnnotationValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithAnnotation(): void
    {
        $this->collection->add(new Behaviour(''));
        $isValid = $this->collectionHasAnnotationValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->collectionHasAnnotationValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(WithoutAnnotationError::class, $this->collectionHasAnnotationValidate->getError());
    }
}
