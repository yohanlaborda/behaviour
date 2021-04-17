<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validate\ScopeIsClassValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\ScopeIsClassValidate
 */
final class ScopeIsClassValidateTest extends TestCase
{
    private ScopeIsClassValidate $scopeIsClassValidate;

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
        $this->scopeIsClassValidate = new ScopeIsClassValidate();
        $this->node = $this->createMock(ClassMethod::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithoutScopeInClass(): void
    {
        $isValid = $this->scopeIsClassValidate->isValid($this->node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithScopeInClass(): void
    {
        $this->scope->method('isInClass')->willReturn(true);

        $isValid = $this->scopeIsClassValidate->isValid($this->node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->scopeIsClassValidate->finishAfterFail());
    }
}
