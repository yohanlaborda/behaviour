<?php

namespace yohanlaborda\behaviour\Tests\Utility;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use yohanlaborda\behaviour\Utility\ClassNameFromScope;

/**
 * @covers \yohanlaborda\behaviour\Utility\ClassNameFromScope
 */
final class ClassNameFromScopeTest extends TestCase
{
    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $this->scope = $this->createMock(Scope::class);
    }

    public function testGetNameWithUnknownName(): void
    {
        $name = ClassNameFromScope::getName($this->scope);

        self::assertSame('unknown', $name);
    }

    public function testGetNameWithName(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(ReflectionClass::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);

        $name = ClassNameFromScope::getName($this->scope);

        self::assertSame('ReflectionClass', $name);
    }
}
