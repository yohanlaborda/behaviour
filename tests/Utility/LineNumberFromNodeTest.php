<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PhpParser\Node;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Utility\LineNumberFromNode;

/**
 * @covers \yohanlaborda\behaviour\Utility\LineNumberFromNode
 */
final class LineNumberFromNodeTest extends TestCase
{
    /**
     * @var Node&MockObject
     */
    private MockObject $node;

    protected function setUp(): void
    {
        $this->node = $this->createMock(Node::class);
    }

    public function testIsUndefinedLineNumberWithWrongStartLine(): void
    {
        $node = $this->createMock(Node::class);
        $node->method('getStartLine')->willReturn(-1);

        self::assertTrue(LineNumberFromNode::isUndefinedLineNumber($node));
    }

    public function testIsUndefinedLineNumberWithWrongEndLine(): void
    {
        $node = $this->createMock(Node::class);
        $node->method('getStartLine')->willReturn(1);
        $node->method('getEndLine')->willReturn(-1);

        self::assertTrue(LineNumberFromNode::isUndefinedLineNumber($node));
    }

    public function testIsUndefinedLineNumberReturnFalse(): void
    {
        $node = $this->createMock(Node::class);
        $node->method('getStartLine')->willReturn(1);
        $node->method('getEndLine')->willReturn(2);

        self::assertFalse(LineNumberFromNode::isUndefinedLineNumber($node));
    }
}
