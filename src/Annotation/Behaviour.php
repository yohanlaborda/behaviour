<?php

namespace yohanlaborda\behaviour\Annotation;

/**
 * @codeCoverageIgnore
 */
final class Behaviour
{
    private string $file;
    private bool $error = false;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function hasError(): bool
    {
        return $this->error;
    }

    public function markWithError(): void
    {
        $this->error = true;
    }
}
