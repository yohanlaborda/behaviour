<?php

namespace yohanlaborda\PHPStan\Configuration;

/**
 * @codeCoverageIgnore
 */
final class BehaviourConfiguration
{
    /**
     * @var string[]
     */
    private array $expressions;

    /**
     * @var string[]
     */
    private array $extensions;

    /**
     * @param string[] $expressions
     * @param string[] $extensions
     */
    public function __construct(array $expressions, array $extensions)
    {
        $this->expressions = $expressions;
        $this->extensions = $extensions;
    }

    /**
     * @return string[]
     */
    public function getExpressions(): array
    {
        return $this->expressions;
    }

    /**
     * @return string[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }
}
