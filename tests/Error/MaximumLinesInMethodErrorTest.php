<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use PHPStan\Analyser\Scope;
use ReflectionClass;
use yohanlaborda\behaviour\Error\MaximumLinesInMethodError;

/**
 * @covers \yohanlaborda\behaviour\Error\MaximumLinesInMethodError
 */
final class MaximumLinesInMethodErrorTest extends TestCase
{
    public function testCreate(): void
    {
        $node = $this->createMock(ClassMethod::class);
        $node->name = $this->createMock(Identifier::class);
        $node->name->name = 'execute';
        $scope = $this->createMock(Scope::class);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(ReflectionClass::class);
        $scope->method('getClassReflection')->willReturn($classReflection);

        $errors = (new MaximumLinesInMethodError(20))->create($node, $scope);
        $firstError = $errors[0];

        self::assertSame(
            'The "execute" method of the "ReflectionClass" class has more than "20" lines.',
            $firstError
        );
    }
}
