<?php

namespace yohanlaborda\behaviour\Annotation;

/**
 * @codeCoverageIgnore
 */
final class Behaviour
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function getFile(): string
    {
        return $this->file;
    }
}
