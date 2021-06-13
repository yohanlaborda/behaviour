<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PhpParser\Node\Stmt;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Utility\CountStmts;

/**
 * @covers \yohanlaborda\behaviour\Utility\CountStmts
 */
final class CountStmtsTest extends TestCase
{
    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->scope = $this->createMock(Scope::class);
    }

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
