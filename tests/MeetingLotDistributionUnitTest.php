<?php

namespace App\Tests;

use App\Entity\Meeting;
use PHPUnit\Framework\TestCase;
use App\Entity\MeetingLotDistribution;

class MeetingLotDistributionUnitTest extends TestCase
{
    private $meetingLot;
    private $meeting;

    public function setUp(): void
    {
        $this->meetingLot = new MeetingLotDistribution();
        $this->meeting = new Meeting();

        $this->meetingLot->setAmount(2500000)
             ->setMeeting($this->meeting)
             ->setBeneficiaires("John & Jina");
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->meetingLot->getAmount() == 2500000);
        $this->assertTrue($this->meetingLot->getMeeting() === $this->meeting);
        $this->assertTrue($this->meetingLot->getBeneficiaires() === "John & Jina");
    }
    
    public function testIsFalse()
    {
        $this->meetingLot->setAmount(1)
             ->setMeeting($this->meeting)
             ->setBeneficiaires(100000.00);

        $this->assertFalse($this->meetingLot->getAmount() === 3000000);
        $this->assertFalse($this->meetingLot->getMeeting() != $this->meeting);
        $this->assertFalse($this->meetingLot->getBeneficiaires() === "Jimmy & Cliff");
    }

    public function testIsEmpty()
    {
        $this->meetingLot = new MeetingLotDistribution();

        $this->assertEmpty($this->meetingLot->getAmount());
        $this->assertEmpty($this->meetingLot->getMeeting());
        $this->assertEmpty($this->meetingLot->getBeneficiaires());
    }
}
