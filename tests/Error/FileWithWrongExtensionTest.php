<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileWithWrongExtension;

/**
 * @covers \yohanlaborda\behaviour\Error\FileWithWrongExtension
 */
final class FileWithWrongExtensionTest extends TestCase
{
    private FileWithWrongExtension $fileWithWrongExtension;

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
        $this->fileWithWrongExtension = new FileWithWrongExtension(['feature', 'features']);
        $this->node = $this->createMock(ClassMethod::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testCreateWithAnnotation(): void
    {
        $this->collection->add(new Behaviour('error.php'));
        $errors = $this->fileWithWrongExtension->create($this->node, $this->scope, $this->collection);
        $firstError = $errors[0];

        self::assertSame(
            'The file "error.php" extension is not one of the following: feature, features.',
            $firstError->getMessage()
        );
    }
}
