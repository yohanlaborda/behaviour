<?php

namespace yohanlaborda\behaviour\Tests\Reader;

use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Collection\BehaviourCollection;
use yohanlaborda\behaviour\Reader\AnnotationReader;
use yohanlaborda\behaviour\Tests\debug\Behaviour\Service;
use yohanlaborda\behaviour\Tests\debug\Behaviour\WithoutAnnotationService;

/**
 * @covers \yohanlaborda\behaviour\Reader\AnnotationReader
 */
final class AnnotationReaderTest extends TestCase
{
    private AnnotationReader $annotationReader;

    protected function setUp(): void
    {
        $this->annotationReader = new AnnotationReader();
    }

    public function testGetFromClassNameAndMethodNameWithoutMethod(): void
    {
        $behaviourCollection = $this->annotationReader->getFromClassNameAndMethodName(WithoutAnnotationService::class, 'Method');

        self::assertNull($behaviourCollection);
    }

    public function testGetFromClassNameAndMethodNameWithoutComment(): void
    {
        $behaviourCollection = $this->annotationReader->getFromClassNameAndMethodName(WithoutAnnotationService::class, 'execute');

        self::assertInstanceOf(BehaviourCollection::class, $behaviourCollection);
    }

    public function testGetFromClassNameAndMethodNameWithAnnotations(): void
    {
        $behaviourCollection = $this->annotationReader->getFromClassNameAndMethodName(Service::class, 'execute');

        self::assertCount(1, $behaviourCollection ?? []);
    }
}
