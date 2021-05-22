<?php

namespace yohanlaborda\behaviour\Tests\Validate;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use PHPStan\Analyser\Scope;
use yohanlaborda\behaviour\Validate\NodeIsClassValidate;

/**
 * @covers \yohanlaborda\behaviour\Validate\NodeIsClassValidate
 */
final class NodeIsClassValidateTest extends TestCase
{
    private NodeIsClassValidate $nodeIsClassValidate;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->nodeIsClassValidate = new NodeIsClassValidate();
        $this->scope = $this->createMock(Scope::class);
    }

    public function testIsValidReturnFalse(): void
    {
        $node = $this->createMock(Node::class);
        $isValid = $this->nodeIsClassValidate->isValid($node, $this->scope);

        self::assertFalse($isValid);
    }

    public function testIsValidReturnTrue(): void
    {
        $node = $this->createMock(Class_::class);
        $isValid = $this->nodeIsClassValidate->isValid($node, $this->scope);

        self::assertTrue($isValid);
    }

    public function testFinishAfterFailIsTrue(): void
    {
        self::assertTrue($this->nodeIsClassValidate->finishAfterFail());
    }
}
