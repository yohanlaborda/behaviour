<?php

namespace yohanlaborda\behaviour\Tests\Error;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Error\FileNotExistError;

/**
 * @covers \yohanlaborda\behaviour\Error\FileNotExistError
 */
final class FileNotExistErrorTest extends TestCase
{
    private FileNotExistError $fileNotExistError;

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
        $this->fileNotExistError = new FileNotExistError();
        $this->node = $this->createMock(Node::class);
        $this->scope = $this->createMock(Scope::class);
    }

    public function testCreateWithAnnotation(): void
    {
        $this->collection->add(new Behaviour('error.feature'));

        $errors = $this->fileNotExistError->create($this->node, $this->scope, $this->collection);
        $firstError = $errors[0];

        self::assertSame(
            'The file "error.feature" not exist.',
            $firstError->getMessage()
        );
    }
}
