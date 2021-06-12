<?php

namespace yohanlaborda\behaviour\Tests\debug\Condition;

class ManyIf
{
    public function execute(): void
    {
        if (1 === 2) {
            if (1 === 3) {
                if (1 === 4) {
                    if (1 === 0) {
                        return;
                    }
                }
            }
        }
    }
}
