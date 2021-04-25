<?php

namespace yohanlaborda\PHPStan\Configuration;

/**
 * @codeCoverageIgnore
 */
final class LongMethodConfiguration
{
    private int $maximumLinesInMethod;

    public function __construct(int $maximumLinesInMethod)
    {
        $this->maximumLinesInMethod = $maximumLinesInMethod;
    }

    public function getMaximumLinesInMethod(): int
    {
        return $this->maximumLinesInMethod;
    }
}
