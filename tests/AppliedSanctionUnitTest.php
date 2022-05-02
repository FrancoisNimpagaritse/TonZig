<?php

namespace App\Tests;

use App\Entity\Meeting;
use App\Entity\AppliedSanction;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class AppliedSanctionUnitTest extends TestCase
{
    /** @var AppliedSanction */
    private $sanction;
    private $meeting;
    private $member;

    public function setUp(): void
    {
        $this->sanction = new AppliedSanction();
        $this->meeting = new Meeting();
        $this->member = new User();

        $this->sanction->setAmount(2500000)
             ->setMeeting($this->meeting)
             ->setMember($this->member)
             ->setSanctionType('retard');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->sanction->getAmount() == 2500000);
        $this->assertTrue($this->sanction->getMeeting() === $this->meeting);
        $this->assertTrue($this->sanction->getMember() === $this->member);
        $this->assertTrue($this->sanction->getSanctionType() === 'retard');
    }
    
    public function testIsFalse()
    {
        $this->sanction->setAmount(2500000)
             ->setMeeting($this->meeting)
             ->setMember($this->member)
             ->setSanctionType('absence');

        $this->assertFalse($this->sanction->getAmount() === 3000000);
        $this->assertFalse($this->sanction->getMeeting() != $this->meeting);
        $this->assertFalse($this->sanction->getMember() === !$this->member);
        $this->assertFalse($this->sanction->getSanctionType() === 'retard');
    }

    public function testIsEmpty()
    {
        $this->sanction = new AppliedSanction();

        $this->assertEmpty($this->sanction->getId());
        $this->assertEmpty($this->sanction->getAmount());
        $this->assertEmpty($this->sanction->getMeeting());
        $this->assertEmpty($this->sanction->getMember());
        $this->assertEmpty($this->sanction->getSanctionType());
    }
}
