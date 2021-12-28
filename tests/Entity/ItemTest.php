<?php

namespace App\Tests\Entity;

use App\Entity\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    public function testIsValid()
    {
        $item = new Item('test', 'test de content');
        $this->assertTrue($item->isValid());
    }

    public function testIsNotUnique()
    {
        $item = new Item('test2', 'test de content');
        $this->assertSame('test2', $item->getName());
    }
}
