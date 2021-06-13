<?php

namespace yohanlaborda\behaviour\Tests\PHPStan\Rule;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Tests\debug\Method\LongMethod;
use yohanlaborda\PHPStan\Configuration\LongMethodConfiguration;
use yohanlaborda\PHPStan\Rule\LongMethodRule;

/**
 * @covers \yohanlaborda\PHPStan\Rule\LongMethodRule
 */
final class LongMethodRuleTest extends TestCase
{
    private LongMethodRule $longMethodRule;

    /**
     * @var ClassMethod&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $longMethodConfiguration = new LongMethodConfiguration(3);
        $this->longMethodRule = new LongMethodRule($longMethodConfiguration);
        $this->node = $this->getMockNode();
        $this->scope = $this->createMock(Scope::class);
        $this->scope->method('isInClass')->willReturn(true);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(LongMethod::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
    }

    /**
     * @return ClassMethod&MockObject
     */
    private function getMockNode(): MockObject
    {
        $node = $this->createMock(ClassMethod::class);
        $node->name = $this->createMock(Identifier::class);
        $node->name->name = 'execute';
        $node->method('isPublic')->willReturn(true);
        $node->method('isMagic')->willReturn(false);

        return $node;
    }

    public function testNodeTypeIsFunctionLike(): void
    {
        self::assertSame($this->longMethodRule->getNodeType(), FunctionLike::class);
    }

    public function testClassWithLongMethod(): void
    {
        $this->node->stmts = [
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class),
            $this->createMock(Stmt::class)
        ];

        $errors = $this->longMethodRule->processNode($this->node, $this->scope);
        $maximumLinesInMethodError = current($errors);

        self::assertSame(
            'The "execute" method of the "yohanlaborda\behaviour\Tests\debug\Method\LongMethod" class has more than "3" lines.',
            $maximumLinesInMethodError instanceof RuleError ? $maximumLinesInMethodError->getMessage() : $maximumLinesInMethodError
        );
    }

    public function testClassWithoutLongMethod(): void
    {
        $this->node->stmts = [];

        $errors = $this->longMethodRule->processNode($this->node, $this->scope);

        self::assertCount(0, $errors);
    }
}
