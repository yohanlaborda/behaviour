<?php

namespace yohanlaborda\behaviour\Utility;

use PhpParser\Node\Stmt;

final class CountStmts
{
    /**
     * @var Stmt[]
     */
    private array $stmts;

    /**
     * @param Stmt[] $stmts
     */
    public function __construct(array $stmts)
    {
        $this->stmts = $stmts;
    }

    public function count(): int
    {
        return $this->countStmts($this->stmts);
    }

    /**
     * @param Stmt[] $stmts
     */
    private function countStmts(array $stmts): int
    {
        $count = 0;
        foreach ($stmts as $stmt) {
            $count += $this->countFromStmt($stmt);
        }

        return $count;
    }

    private function countFromStmt(Stmt $stmt): int
    {
        $count = 1;
        $stmts = property_exists($stmt, 'stmts') ? $stmt->stmts : null;
        if ($stmts !== null && count($stmts) > 0) {
            $count += $this->countStmts($stmts);
        }

        return $count;
    }
}
