<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PhpParser\Node\Stmt;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Utility\CountStmts;

/**
 * @covers \yohanlaborda\behaviour\Utility\CountStmts
 */
final class CountStmtsTest extends TestCase
{
    public function testCount(): void
    {
        $nodes = [
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class)
        ];

        $countStmts = new CountStmts($nodes);

        self::assertSame(3, $countStmts->count());
    }
}
