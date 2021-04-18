<?php

namespace yohanlaborda\behaviour\Tests\PHPStan\Rule;

use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Rules\RuleError;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use yohanlaborda\behaviour\Tests\debug\Behaviour\Service;
use yohanlaborda\behaviour\Tests\debug\Behaviour\Stage;
use yohanlaborda\behaviour\Tests\debug\Behaviour\WithoutAnnotationService;
use yohanlaborda\behaviour\Tests\debug\Behaviour\WithoutMethodService;
use yohanlaborda\PHPStan\Configuration\BehaviourConfiguration;
use yohanlaborda\PHPStan\Rule\BehaviourAnnotationRule;

/**
 * @covers \yohanlaborda\PHPStan\Rule\BehaviourAnnotationRule
 */
final class BehaviourAnnotationRuleTest extends TestCase
{
    private BehaviourAnnotationRule $behaviourAnnotationRule;

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
        $behaviourConfiguration = new BehaviourConfiguration(
            ['/^.+(Service)$/', '/^.+(Stage)$/'],
            ['feature', 'features']
        );
        $this->behaviourAnnotationRule = new BehaviourAnnotationRule($behaviourConfiguration);
        $this->node = $this->createMock(ClassMethod::class);
        $this->node->name = $this->createMock(Identifier::class);
        $this->node->name->name = 'execute';
        $this->node->method('isPublic')->willReturn(true);
        $this->node->method('isMagic')->willReturn(false);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testNodeTypeIsFunctionLike(): void
    {
        self::assertSame($this->behaviourAnnotationRule->getNodeType(), FunctionLike::class);
    }

    public function testClassNotExists(): void
    {
        $errors = $this->behaviourAnnotationRule->processNode($this->node, $this->scope);

        self::assertCount(0, $errors);
    }

    public function testClassWithoutAnnotation(): void
    {
        $reflectionClass = new ReflectionClass(WithoutAnnotationService::class);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(WithoutAnnotationService::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->scope->method('isInClass')->willReturn(true);
        $this->scope->method('getFile')->willReturn($reflectionClass->getFileName());

        $errors = $this->behaviourAnnotationRule->processNode($this->node, $this->scope);
        $fileNotExistError = current($errors);

        self::assertSame(
            'The "execute" method of the "yohanlaborda\behaviour\Tests\debug\Behaviour\WithoutAnnotationService" class does not have the annotation @Behaviour',
            $fileNotExistError instanceof RuleError ? $fileNotExistError->getMessage() : $fileNotExistError
        );
    }

    public function testClassWithoutMethod(): void
    {
        $reflectionClass = new ReflectionClass(WithoutMethodService::class);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(WithoutMethodService::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->scope->method('isInClass')->willReturn(true);
        $this->scope->method('getFile')->willReturn($reflectionClass->getFileName());

        $errors = $this->behaviourAnnotationRule->processNode($this->node, $this->scope);

        self::assertCount(1, $errors);
    }

    public function testClassWithErrorFileNotExist(): void
    {
        $reflectionClass = new ReflectionClass(Stage::class);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(Stage::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->scope->method('isInClass')->willReturn(true);
        $this->scope->method('getFile')->willReturn($reflectionClass->getFileName());

        $errors = $this->behaviourAnnotationRule->processNode($this->node, $this->scope);
        $fileNotExistError = current($errors);
        $fileWithWrongExtensionError = next($errors);

        self::assertCount(2, $errors);
        self::assertSame(
            'The file "ERROR" not exist.',
            $fileNotExistError instanceof RuleError ? $fileNotExistError->getMessage() : $fileNotExistError
        );
        self::assertSame(
            'The file "ERROR" extension is not one of the following: feature, features.',
            $fileWithWrongExtensionError->getMessage()
        );
    }

    public function testClassWithBehaviourAnnotation(): void
    {
        $reflectionClass = new ReflectionClass(Service::class);
        $classReflection = $this->createMock(ClassReflection::class);
        $classReflection->method('getName')->willReturn(Service::class);
        $this->scope->method('getClassReflection')->willReturn($classReflection);
        $this->scope->method('isInClass')->willReturn(true);
        $this->scope->method('getFile')->willReturn($reflectionClass->getFileName());

        $errors = $this->behaviourAnnotationRule->processNode($this->node, $this->scope);

        self::assertCount(0, $errors);
    }
}
