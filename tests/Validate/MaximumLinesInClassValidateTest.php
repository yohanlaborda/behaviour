<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Error\MaximumLinesInClassError;
use yohanlaborda\behaviour\Validate\MaximumLinesInClassValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\MaximumLinesInClassValidate
 */
final class MaximumLinesInClassValidateTest extends TestCase
{
    private MaximumLinesInClassValidate $maximumLinesInClassValidate;

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
        $this->maximumLinesInClassValidate = new MaximumLinesInClassValidate(50);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithNodeIsNotClass(): void
    {
        $isValid = $this->maximumLinesInClassValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithUndefinedLineNumber(): void
    {
        $this->node = $this->createMock(Class_::class);
        $this->node->method('getStartLine')->willReturn(-1);
        $this->node->method('getEndLine')->willReturn(-1);

        $isValid = $this->maximumLinesInClassValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnFalseWhenExceedMaximumLines(): void
    {
        $this->node = $this->createMock(Class_::class);
        $this->node->method('getStartLine')->willReturn(50);
        $this->node->method('getEndLine')->willReturn(200);

        $isValid = $this->maximumLinesInClassValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWhenNotExceedMaximumLines(): void
    {
        $this->node = $this->createMock(Class_::class);
        $this->node->method('getStartLine')->willReturn(50);
        $this->node->method('getEndLine')->willReturn(60);

        $isValid = $this->maximumLinesInClassValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->maximumLinesInClassValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(MaximumLinesInClassError::class, $this->maximumLinesInClassValidate->getError());
    }
}
