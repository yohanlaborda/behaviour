<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validate\MethodNameIsNotConstructValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\MethodNameIsNotConstructValidate
 */
final class MethodNameIsNotConstructValidateTest extends TestCase
{
    private MethodNameIsNotConstructValidate $methodNameIsNotConstructValidate;

    /**
     * @var Node&ClassMethod&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->methodNameIsNotConstructValidate = new MethodNameIsNotConstructValidate();
        $this->node = $this->createMock(ClassMethod::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithMethodNameConstruct(): void
    {
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = '__construct';

        $isValid = $this->methodNameIsNotConstructValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithMethodName(): void
    {
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = 'execute';

        $isValid = $this->methodNameIsNotConstructValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->methodNameIsNotConstructValidate->finishAfterFail());
    }
}
