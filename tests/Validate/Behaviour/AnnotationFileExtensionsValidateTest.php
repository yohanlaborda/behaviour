<?php

namespace yohanlaborda\behaviour\Tests\Validate\Behaviour;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileWithWrongExtensionError;
use yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExtensionsValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExtensionsValidate
 */
final class AnnotationFileExtensionsValidateTest extends TestCase
{
    private AnnotationFileExtensionsValidate $annotationFileExtensionsValidate;

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
        $this->annotationFileExtensionsValidate = new AnnotationFileExtensionsValidate(
            $this->collection,
            ['feature', 'features']
        );
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithoutAnnotation(): void
    {
        $isValid = $this->annotationFileExtensionsValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnFalseWithWrongAnnotation(): void
    {
        $this->collection->add(new Behaviour('service.coco'));
        $isValid = $this->annotationFileExtensionsValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidWithFile(): void
    {
        $this->collection->add(new Behaviour('service.feature'));
        $isValid = $this->annotationFileExtensionsValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsFalse(): void
    {
        self::assertFalse($this->annotationFileExtensionsValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(FileWithWrongExtensionError::class, $this->annotationFileExtensionsValidate->getError());
    }
}
