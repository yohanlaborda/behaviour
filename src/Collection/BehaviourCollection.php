<?php

namespace yohanlaborda\behaviour\Collection;

use yohanlaborda\behaviour\Annotation\Behaviour;
use Countable;

final class BehaviourCollection implements Countable
{
    /**
     * @var Behaviour[]
     */
    private array $annotations;

    public function __construct()
    {
        $this->annotations = [];
    }

    public function add(Behaviour $behaviour): void
    {
        $this->annotations[] = $behaviour;
    }

    /**
     * @return Behaviour[]
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    public function hasAnnotations(): bool
    {
        return $this->count() > 0;
    }

    public function notHasAnnotations(): bool
    {
        return $this->hasAnnotations() === false;
    }

    public function count(): int
    {
        return count($this->annotations);
    }
}
