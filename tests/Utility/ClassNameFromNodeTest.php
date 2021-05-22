<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Utility\ClassNameFromNode;

/**
 * @covers \yohanlaborda\behaviour\Utility\ClassNameFromNode
 */
final class ClassNameFromNodeTest extends TestCase
{
    public function testGetNameWithUnknownName(): void
    {
        $node = $this->createMock(Node::class);
        $name = ClassNameFromNode::getName($node);

        self::assertSame('unknown', $name);
    }

    public function testGetNameWithNodeClassMethod(): void
    {
        $node = $this->createMock(Class_::class);
        $node->name = $this->createMock(Identifier::class);
        $node->name->name = 'ClassName';
        $name = ClassNameFromNode::getName($node);

        self::assertSame('ClassName', $name);
    }
}
