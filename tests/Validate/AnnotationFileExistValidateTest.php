<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileNotExistError;
use yohanlaborda\behaviour\Validate\AnnotationFileExistValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\AnnotationFileExistValidate
 */
final class AnnotationFileExistValidateTest extends TestCase
{
    private AnnotationFileExistValidate $annotationFileExistValidate;

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
        $this->annotationFileExistValidate = new AnnotationFileExistValidate($this->collection);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithoutAnnotation(): void
    {
        $isValid = $this->annotationFileExistValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnFalseWithoutFile(): void
    {
        $this->collection->add(new Behaviour('file.txt'));
        $isValid = $this->annotationFileExistValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidWithFile(): void
    {
        $this->collection->add(new Behaviour(__DIR__ . '/../debug/service.feature'));
        $isValid = $this->annotationFileExistValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsFalse(): void
    {
        self::assertFalse($this->annotationFileExistValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(FileNotExistError::class, $this->annotationFileExistValidate->getError());
    }
}
