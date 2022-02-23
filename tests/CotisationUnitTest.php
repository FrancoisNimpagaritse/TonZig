<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Meeting;
use App\Entity\Cotisation;
use PHPUnit\Framework\TestCase;

class CotisationUnitTest extends TestCase
{
    private $cotisation;
    private $member;
    private $meeting;

    public function setUp(): void
    {
        $this->cotisation = new Cotisation();
        $this->member = new User();
        $this->meeting = new Meeting();

        $this->cotisation->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setNote('Fully paid');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->cotisation->getAmount() === 1000000.00);
        $this->assertTrue($this->cotisation->getMember() === $this->member);
        $this->assertTrue($this->cotisation->getMeeting() === $this->meeting);
        $this->assertTrue($this->cotisation->getNote() === 'Fully paid');
    }
    
    public function testIsFalse()
    {
        $this->cotisation->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setNote('full paid');

        $this->assertFalse($this->cotisation->getAmount() === 90000.00);
        $this->assertFalse($this->cotisation->getMember() === new User());
        $this->assertFalse($this->cotisation->getMeeting() === new Meeting());
        $this->assertFalse($this->cotisation->getNote() === 'paid');
    }

    public function testIsEmpty()
    {
        $this->cotisation = new Cotisation();

        $this->assertEmpty($this->cotisation->getAmount());
        $this->assertEmpty($this->cotisation->getMember());
        $this->assertEmpty($this->cotisation->getMeeting());
        $this->assertEmpty($this->cotisation->getNote());
    }
}
