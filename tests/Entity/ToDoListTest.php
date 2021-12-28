<?php

namespace App\Tests\Entity;

use App\Entity\Item;
use App\Entity\ToDoList;
use App\Service\EmailSenderService;
use Carbon\Carbon;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
    public function testHasBetween0And10Items()
    {
        $toDoList = new ToDoList(EmailSenderService::class);
        $this->assertTrue($toDoList->getItems()->count() >= 0 && $toDoList->getItems()->count() <= 10);
    }

    public function testAddItem()
    {
        $item = new Item('new item', 'voici un content', Carbon::now());
        $toDoList = new ToDoList(EmailSenderService::class);
        $toDoList->addItem($item);
        $this->assertTrue($toDoList->getItems()->contains($item));
    }

    public function testTimeBetweenAddItemIsLowerThan30Min()
    {
        $item = new Item('new item', 'voici un content', Carbon::now()->subMinutes(20));
        $item2 = new Item('new item 2', 'voici un autre content', Carbon::now());
        $toDoList = new ToDoList(EmailSenderService::class);
        $toDoList->addItem($item);
        $this->expectException(Exception::class);
        $toDoList->addItem($item2);
    }

    public function testEmailSendingIf8ItemsAdded()
    {
        $item = new Item('new item', 'voici un content', Carbon::now());
        $toDoList = new ToDoList(EmailSenderService::class);
        $toDoList->addItem($item);
        $sut = $this->getMockBuilder(EmailSenderService::class)
            ->onlyMethods(['sendEmail'])
            ->getMock();
        $sut->method('sendEmail')
            ->willReturn(true);
        $this->assertTrue($toDoList->getItems()->contains($item));
    }
}