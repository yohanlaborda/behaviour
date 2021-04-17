<?php

namespace yohanlaborda\behaviour\Reader;

use Exception;
use ReflectionClass;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

final class AnnotationReader
{
    private const PATTERN_COMMENT = '#@(Behaviour)\(\"(.*)\"\)#i';
    private const POSITION_IN_ARRAY = 2;

    /**
     * @param class-string $className
     */
    public function getFromClassNameAndMethodName(string $className, string $methodName): ?BehaviourCollection
    {
        try {
            $reflectionClass = new ReflectionClass($className);
            $method = $reflectionClass->getMethod($methodName);
        } catch (Exception $exception) {
            return null;
        }

        $comment = $method->getDocComment();
        if (false === $comment) {
            return new BehaviourCollection();
        }

        return $this->getFromComment($comment);
    }

    private function getFromComment(string $comment): BehaviourCollection
    {
        preg_match_all(self::PATTERN_COMMENT, $comment, $matches, PREG_PATTERN_ORDER);

        $annotations = new BehaviourCollection();
        $listFiles = $matches[self::POSITION_IN_ARRAY] ?? [];
        foreach ($listFiles as $file) {
            $annotations->add(new Behaviour($file));
        }

        return $annotations;
    }
}
