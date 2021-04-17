<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validate\NodeIsClassMethodValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\NodeIsClassMethodValidate
 */
final class NodeIsClassMethodValidateTest extends TestCase
{
    private NodeIsClassMethodValidate $nodeIsClassMethodValidate;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->nodeIsClassMethodValidate = new NodeIsClassMethodValidate();
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithNode(): void
    {
        $node = $this->createMock(Node::class);
        $isValid = $this->nodeIsClassMethodValidate->isValid($node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithNodeClassMethod(): void
    {
        $node = $this->createMock(ClassMethod::class);
        $isValid = $this->nodeIsClassMethodValidate->isValid($node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->nodeIsClassMethodValidate->finishAfterFail());
    }
}
