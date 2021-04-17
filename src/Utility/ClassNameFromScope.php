<?php

namespace yohanlaborda\behaviour\Utility;

use PHPStan\Analyser\Scope;

final class ClassNameFromScope
{
    /**
     * @param Scope $scope
     * @return string
     */
    public static function getName(Scope $scope): string
    {
        $classReflection = $scope->getClassReflection();

        return $classReflection ? $classReflection->getName() : 'unknown';
    }
}
