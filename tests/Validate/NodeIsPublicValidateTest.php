<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validate\NodeIsPublicValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\NodeIsPublicValidate
 */
final class NodeIsPublicValidateTest extends TestCase
{
    private NodeIsPublicValidate $nodeIsPublicValidate;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->nodeIsPublicValidate = new NodeIsPublicValidate();
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalseWithNode(): void
    {
        $node = $this->createMock(Node::class);
        $isValid = $this->nodeIsPublicValidate->isValid($node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrueWithNodePublic(): void
    {
        $node = $this->createMock(ClassMethod::class);
        $node->method('isPublic')->willReturn(true);
        $isValid = $this->nodeIsPublicValidate->isValid($node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->nodeIsPublicValidate->finishAfterFail());
    }
}
