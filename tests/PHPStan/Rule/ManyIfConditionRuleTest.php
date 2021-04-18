<?php

namespace yohanlaborda\behaviour\Tests\PHPStan\Rule;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\If_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Tests\debug\Condition\ManyIf;
use yohanlaborda\PHPStan\Configuration\ManyIfConfiguration;
use yohanlaborda\PHPStan\Rule\ManyIfConditionRule;

/**
 * @covers \yohanlaborda\PHPStan\Rule\ManyIfConditionRule
 */
final class ManyIfConditionRuleTest extends TestCase
{
    private ManyIfConditionRule $manyIfConditionRule;

    /**
     * @var FunctionLike&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    protected function setUp(): void
    {
        $manyIfConfiguration = new ManyIfConfiguration(3);
        $this->manyIfConditionRule = new ManyIfConditionRule($manyIfConfiguration);
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = 'execute';
        $this->scope = $this->createMock(Scope::class);
    }

    public function testNodeTypeIsFunctionLike(): void
    {
        self::assertSame($this->manyIfConditionRule->getNodeType(), FunctionLike::class);
    }

    public function testClassNotExists(): void
    {
        $errors = $this->manyIfConditionRule->processNode($this->node, $this->scope);

        self::assertCount(0, $errors);
    }

    public function testClassWithoutAnnotation(): void
    {
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(ManyIf::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->scope->method('isInClass')->willReturn(true);
        $this->node->method('getStmts')->willReturn([
            $this->createMock(If_::class),
            $this->createMock(If_::class),
            $this->createMock(If_::class),
            $this->createMock(If_::class)
        ]);

        $errors = $this->manyIfConditionRule->processNode($this->node, $this->scope);
        $fileNotExistError = current($errors);

        self::assertSame(
            'The "execute" method of the "yohanlaborda\behaviour\Tests\debug\Condition\ManyIf" class has more than "3" if conditions',
            $fileNotExistError instanceof RuleError ? $fileNotExistError->getMessage() : $fileNotExistError
        );
    }
}
