<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Meeting;
use App\Entity\CaisseSociale;
use PHPUnit\Framework\TestCase;

class CaisseSocialeUnitTest extends TestCase
{
    private $caisse;
    private $member;
    private $meeting;

    public function setUp(): void
    {
        $this->caisse = new CaisseSociale();
        $this->member = new User();
        $this->meeting = new Meeting();

        $this->caisse->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setNote('Fully paid');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->caisse->getAmount() === 1000000.00);
        $this->assertTrue($this->caisse->getMember() === $this->member);
        $this->assertTrue($this->caisse->getMeeting() === $this->meeting);
        $this->assertTrue($this->caisse->getNote() === 'Fully paid');
    }
    
    public function testIsFalse()
    {
        $this->caisse->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setNote('full paid');

        $this->assertFalse($this->caisse->getAmount() === 90000.00);
        $this->assertFalse($this->caisse->getMember() === new User());
        $this->assertFalse($this->caisse->getMeeting() === new Meeting());
        $this->assertFalse($this->caisse->getNote() === 'paid');
    }

    public function testIsEmpty()
    {
        $this->caisse = new CaisseSociale();

        $this->assertEmpty($this->caisse->getId());
        $this->assertEmpty($this->caisse->getAmount());
        $this->assertEmpty($this->caisse->getMember());
        $this->assertEmpty($this->caisse->getMeeting());
        $this->assertEmpty($this->caisse->getNote());
    }
}
