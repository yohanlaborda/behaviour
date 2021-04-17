<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\WithoutAnnotationError;

/**
 * @covers \yohanlaborda\behaviour\Error\WithoutAnnotationError
 */
final class WithoutAnnotationErrorTest extends TestCase
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

        $errors = (new WithoutAnnotationError())->create($node, $scope, new BehaviourCollection());
        $firstError = $errors[0];

        self::assertSame(
            'The "execute" method of the "ReflectionClass" class does not have the annotation @Behaviour',
            $firstError->getMessage()
        );
    }
}
