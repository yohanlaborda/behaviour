<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Utility\MethodNameFromNode;

/**
 * @covers \yohanlaborda\behaviour\Utility\MethodNameFromNode
 */
final class MethodNameFromNodeTest extends TestCase
{
    public function testGetNameWithUnknownName(): void
    {
        $node = $this->createMock(Node::class);
        $name = MethodNameFromNode::getName($node);

        self::assertSame('unknown', $name);
    }

    public function testGetNameWithNodeClassMethod(): void
    {
        $node = $this->createMock(ClassMethod::class);
        $node->name = $this->createMock(Identifier::class);
        $node->name->name = 'execute';
        $name = MethodNameFromNode::getName($node);

        self::assertSame('execute', $name);
    }
}
