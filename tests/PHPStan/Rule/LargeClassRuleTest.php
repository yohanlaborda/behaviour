<?php

namespace yohanlaborda\behaviour\Tests\PHPStan\Rule;

use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use yohanlaborda\behaviour\Tests\debug\LargeClass;
use yohanlaborda\PHPStan\Configuration\LargeClassConfiguration;
use yohanlaborda\PHPStan\Rule\LargeClassRule;

/**
 * @covers \yohanlaborda\PHPStan\Rule\LargeClassRule
 */
final class LargeClassRuleTest extends TestCase
{
    private LargeClassRule $largeClassRule;

    /**
     * @var Class_&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $largeClassConfiguration = new LargeClassConfiguration(50);
        $reflectionClass = new ReflectionClass(LargeClass::class);
        $this->largeClassRule = new LargeClassRule($largeClassConfiguration);
        $this->node = $this->createMock(Class_::class);
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = $reflectionClass->getShortName();
        $this->scope = $this->createMock(Scope::class);
        $this->scope->method('getNamespace')->willReturn($reflectionClass->getNamespaceName());
    }

    public function testNodeTypeIsFunctionLike(): void
    {
        self::assertSame($this->largeClassRule->getNodeType(), ClassLike::class);
    }

    public function testLargeClassWithError(): void
    {
        $this->node->method('getStartLine')->willReturn(50);
        $this->node->method('getEndLine')->willReturn(250);

        $errors = $this->largeClassRule->processNode($this->node, $this->scope);
        $largeClassError = current($errors);

        self::assertSame(
            'The "yohanlaborda\behaviour\Tests\debug\LargeClass" class has more than "50" lines.',
            $largeClassError instanceof RuleError ? $largeClassError->getMessage() : $largeClassError
        );
    }

    public function testLargeClassWithoutError(): void
    {
        $this->node->method('getStartLine')->willReturn(50);
        $this->node->method('getEndLine')->willReturn(80);

        $errors = $this->largeClassRule->processNode($this->node, $this->scope);

        self::assertCount(0, $errors);
    }
}
