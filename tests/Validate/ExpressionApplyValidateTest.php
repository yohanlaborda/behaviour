<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validate\ExpressionApplyValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\ExpressionApplyValidate
 */
final class ExpressionApplyValidateTest extends TestCase
{
    private ExpressionApplyValidate $expressionApplyValidate;

    /**
     * @var Node&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->expressionApplyValidate = new ExpressionApplyValidate(['/^.+(Service)$/', '/^.+(Stage)$/']);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithUnknownClass(): void
    {
        $isValid = $this->expressionApplyValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithClassService(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn('ClassService');
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $isValid = $this->expressionApplyValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnTrueWithClassStage(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn('ClassStage');
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $isValid = $this->expressionApplyValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->expressionApplyValidate->finishAfterFail());
    }
}
