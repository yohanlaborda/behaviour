<?php

namespace yohanlaborda\behaviour\Validator;

use Countable;
use Iterator;

/**
 * @phpstan-implements Iterator<int, ValidateInterface>
 */
final class ValidateList implements Countable, Iterator
{
    /**
     * @var array<int, ValidateInterface>
     */
    private array $validate;
    private int $index = 0;

    /**
     * @param array<int, ValidateInterface> $validate
     */
    public function __construct(array $validate = [])
    {
        $this->validate = $validate;
    }

    public function add(ValidateInterface $validate): void
    {
        $this->validate[] = $validate;
    }

    public function remove(ValidateInterface $validateToRemove): void
    {
        foreach ($this->validate as $key => $validate) {
            $validateClassName = get_class($validate);
            $validateToRemoveClassName = get_class($validateToRemove);
            if ($validateClassName === $validateToRemoveClassName) {
                unset($this->validate[$key]);
            }
        }

        $this->validate = array_values($this->validate);
    }

    public function count(): int
    {
        return count($this->validate);
    }

    public function current(): ValidateInterface
    {
        return $this->validate[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->validate[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
