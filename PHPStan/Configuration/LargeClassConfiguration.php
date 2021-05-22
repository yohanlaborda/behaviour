<?php

namespace yohanlaborda\PHPStan\Configuration;

/**
 * @codeCoverageIgnore
 */
final class LargeClassConfiguration
{
    private int $maximumLinesInClass;

    public function __construct(int $maximumLinesInClass)
    {
        $this->maximumLinesInClass = $maximumLinesInClass;
    }

    public function getMaximumLinesInClass(): int
    {
        return $this->maximumLinesInClass;
    }
}
