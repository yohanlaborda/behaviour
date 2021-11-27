<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileWithWrongExtensionError;

/**
 * @covers \yohanlaborda\behaviour\Error\FileWithWrongExtensionError
 */
final class FileWithWrongExtensionErrorTest extends TestCase
{
    private FileWithWrongExtensionError $fileWithWrongExtension;

    /**
     * @var Node&MockObject
     */
    private $node;

    /**
     * @var Scope&MockObject
     */
    private $scope;

    /**
     * @var BehaviourCollection
     */
    private BehaviourCollection $collection;

    protected function setUp(): void
    {
        $this->collection = new BehaviourCollection();
        $this->fileWithWrongExtension = new FileWithWrongExtensionError($this->collection, ['feature', 'features']);
        $this->node = $this->createMock(ClassMethod::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testCreateWithAnnotation(): void
    {
        $behaviour = new Behaviour('error.feature');
        $behaviour->markWithError();
        $this->collection->add($behaviour);
        $errors = $this->fileWithWrongExtension->create($this->node, $this->scope);
        $firstError = $errors[0];

        self::assertSame(
            'The file "error.feature" extension is not one of the following: feature, features.',
            $firstError
        );
    }
}
