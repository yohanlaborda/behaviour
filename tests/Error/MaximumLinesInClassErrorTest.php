<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Error\MaximumLinesInClassError;

/**
 * @covers \yohanlaborda\behaviour\Error\MaximumLinesInClassError
 */
final class MaximumLinesInClassErrorTest extends TestCase
{
    public function testCreate(): void
    {
        $node = $this->createMock(Class_::class);
        $node->name = $this->createMock(Identifier::class);
        $node->name->name = 'ReflectionClass';
        $scope = $this->createMock(Scope::class);
        $scope->method('getNamespace')->willReturn('test');

        $errors = (new MaximumLinesInClassError(200))->create($node, $scope);
        $firstError = $errors[0];

        self::assertSame(
            'The "test\ReflectionClass" class has more than "200" lines.',
            $firstError
        );
    }
}
