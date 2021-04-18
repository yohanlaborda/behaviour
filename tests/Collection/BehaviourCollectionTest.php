<?php

namespace yohanlaborda\behaviour\Tests\Collection;

use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Annotation\Behaviour;
use yohanlaborda\behaviour\Collection\BehaviourCollection;

/**
 * @covers \yohanlaborda\behaviour\Collection\BehaviourCollection
 */
final class BehaviourCollectionTest extends TestCase
{
    private BehaviourCollection $behaviourCollection;

    protected function setUp(): void
    {
        $this->behaviourCollection = new BehaviourCollection();
    }

    public function testGetAnnotationsWithOnlyOneValue(): void
    {
        $this->behaviourCollection->add(new Behaviour(''));

        self::assertCount(1, $this->behaviourCollection->getAnnotations());
    }

    public function testHasAnnotationsReturnTrue(): void
    {
        $this->behaviourCollection->add(new Behaviour(''));

        self::assertTrue($this->behaviourCollection->hasAnnotations());
    }

    public function testNotHasAnnotationsReturnTrue(): void
    {
        self::assertTrue($this->behaviourCollection->notHasAnnotations());
    }
}
