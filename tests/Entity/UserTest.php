<?php

namespace App\Tests\Entity;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Controller\ExternalAPIs;

class UserTest extends TestCase {

    public function testIsValid(): void {
        $sut = $this->getMockBuilder(ExternalAPIs::class)
            ->onlyMethods(['checkEmail'])
            ->getMock();
        $sut->method('checkEmail')
            ->willReturn(true);
        $user = new User('test@test.fr', 'Rodriguez', 'Juan', 'password', Carbon::now()->subYears(13), $sut);
        $this->assertTrue($user->IsValid());
    }

    public function testIsNotValid(): void {
        $sut = $this->getMockBuilder(ExternalAPIs::class)
            ->onlyMethods(['checkEmail'])
            ->getMock();
        $sut->method('checkEmail')
            ->willReturn(false);
        $user = new User('test@test.fr', 'Rodriguez', 'Juan', 'passwor', Carbon::now()->subYears(13), $sut);
        $this->assertFalse($user->IsValid());
    }


}