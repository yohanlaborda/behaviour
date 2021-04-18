<?php

namespace yohanlaborda\PHPStan\Configuration;

/**
 * @codeCoverageIgnore
 */
final class ManyIfConfiguration
{
    private int $maximumIfAllowed;

    public function __construct(int $maximumIfAllowed)
    {
        $this->maximumIfAllowed = $maximumIfAllowed;
    }

    public function getMaximumIfAllowed(): int
    {
        return $this->maximumIfAllowed;
    }
}
