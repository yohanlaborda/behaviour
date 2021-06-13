<?php

namespace yohanlaborda\behaviour\Tests\Validate\Method;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Error\MaximumLinesInMethodError;
use yohanlaborda\behaviour\Validate\Method\MaximumLinesInMethodValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\Method\MaximumLinesInMethodValidate
 */
final class MaximumLinesInMethodValidateTest extends TestCase
{
    private MaximumLinesInMethodValidate $maximumLinesInMethodValidate;

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
        $this->maximumLinesInMethodValidate = new MaximumLinesInMethodValidate(3);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithWrongNode(): void
    {
        $isValid = $this->maximumLinesInMethodValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithoutStmts(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $isValid = $this->maximumLinesInMethodValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnTrueTotalLineIsLessThanMaximum(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->stmts = [];
        $isValid = $this->maximumLinesInMethodValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnFalseTotalLineIsGreaterThanMaximum(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->stmts = [
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class)
        ];
        $isValid = $this->maximumLinesInMethodValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->maximumLinesInMethodValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(MaximumLinesInMethodError::class, $this->maximumLinesInMethodValidate->getError());
    }
}
