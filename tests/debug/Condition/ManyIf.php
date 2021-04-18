<?php

namespace yohanlaborda\behaviour\Tests\debug\Condition;

class ManyIf
{
    public function execute(): void
    {
        if (1 === 2) {
            return;
        }

        if (1 === 3) {
            return;
        }

        if (1 === 4) {
            return;
        }

        if (1 === 0) {
            return;
        }
    }
}
