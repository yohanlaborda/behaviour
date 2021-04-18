<?php

namespace yohanlaborda\behaviour\Tests\Validate\Condition;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Error\MaximumIfAllowedError;
use yohanlaborda\behaviour\Validate\Condition\MaximumIfAllowedValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\Condition\MaximumIfAllowedValidate
 */
final class MaximumIfAllowedValidateTest extends TestCase
{
    private MaximumIfAllowedValidate $maximumIfAllowedValidate;

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
        $this->maximumIfAllowedValidate = new MaximumIfAllowedValidate(2);
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithWrongNode(): void
    {
        $isValid = $this->maximumIfAllowedValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithoutStmts(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $isValid = $this->maximumIfAllowedValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnTrueWithoutIfStmts(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->method('getStmts')->willReturn([
            $this->createMock(Stmt::class)
        ]);
        $isValid = $this->maximumIfAllowedValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testIsValidReturnFalseWithIfStmts(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->method('getStmts')->willReturn([
            $this->createMock(If_::class),
            $this->createMock(If_::class),
            $this->createMock(If_::class),
        ]);
        $isValid = $this->maximumIfAllowedValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithIfStmts(): void
    {
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->method('getStmts')->willReturn([
            $this->createMock(If_::class),
            $this->createMock(If_::class)
        ]);
        $isValid = $this->maximumIfAllowedValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->maximumIfAllowedValidate->finishAfterFail());
    }

    public function testGetErrorWithClass(): void
    {
        self::assertInstanceOf(MaximumIfAllowedError::class, $this->maximumIfAllowedValidate->getError());
    }
}
