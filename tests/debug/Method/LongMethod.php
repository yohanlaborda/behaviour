<?php

namespace yohanlaborda\behaviour\Tests\debug\Method;

class LongMethod
{
    public function execute(int $b): void
    {
        $a = $b;
        $c = $b;

        $a = $b;
        $c = $b;

        $a = $b;
        $c = $b;

        if ($b === 2) {
            return;
        }

        $b = 1;
        $a = $b;
        $c = $b;

        if ($b === 4) {
            return;
        }

        if ($b === 3) {
            return;
        }
    }
}
