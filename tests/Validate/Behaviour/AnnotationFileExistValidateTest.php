<?php

namespace yohanlaborda\behaviour\Tests\Validate\Behaviour;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileNotExistError;
use yohanlaborda\behaviour\Tests\debug\Behaviour\Service;
use yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExistValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\Behaviour\AnnotationFileExistValidate
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

    public function testIsValidReturnFalseWithReflection(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(Service::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->collection->add(new Behaviour('file.txt'));
        $isValid = $this->annotationFileExistValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnFalseWithWrongReflection(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->collection->add(new Behaviour('file.txt'));
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
        $this->collection->add(new Behaviour(__DIR__ . '/../../debug/Behaviour/service.feature'));
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
