<?php

namespace yohanlaborda\behaviour\Tests\Validator;

use PHPUnit\Framework\TestCase;
use yohanlaborda\behaviour\Validator\ValidateInterface;
use yohanlaborda\behaviour\Validator\ValidateList;

/**
 * @covers \yohanlaborda\behaviour\Validate\ValidateList
 */
final class ValidateListTest extends TestCase
{
    public function testAddAndGetCurrent(): void
    {
        $validate = $this->createMock(ValidateInterface::class);
        $validateList = new ValidateList();
        $validateList->add($validate);

        self::assertSame(get_class($validate), get_class($validateList->current()));
    }

    public function testAddAndRemove(): void
    {
        $validate = $this->createMock(ValidateInterface::class);
        $validateList = new ValidateList();
        $validateList->add($validate);
        $validateList->remove($validate);

        self::assertSame($validateList->count(), 0);
    }

    public function testCurrentKey(): void
    {
        $validateList = new ValidateList();

        self::assertSame($validateList->key(), 0);
    }

    public function testNextIndex(): void
    {
        $validateList = new ValidateList();
        $validateList->next();

        self::assertSame($validateList->key(), 1);
    }

    public function testValidReturnTrue(): void
    {
        $validate = $this->createMock(ValidateInterface::class);
        $validateList = new ValidateList();
        $validateList->add($validate);

        self::assertTrue($validateList->valid());
    }

    public function testValidReturnFalse(): void
    {
        $validate = $this->createMock(ValidateInterface::class);
        $validateList = new ValidateList();
        $validateList->add($validate);
        $validateList->next();

        self::assertFalse($validateList->valid());
    }

    public function testRewind(): void
    {
        $validateList = new ValidateList();
        $validateList->next();
        $validateList->rewind();

        self::assertSame($validateList->key(), 0);
    }
}
