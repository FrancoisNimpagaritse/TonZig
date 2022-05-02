<?php

namespace App\Tests;

use App\Entity\Meeting;
use DateTime;
use App\Entity\Round;
use PHPUnit\Framework\TestCase;

class RoundUnitTest extends TestCase
{
    /** @var Round */
    private $round;
    private $date;
    private $closingDate;

    public function setUp(): void
    {
        $this->round = new Round();
        $this->date = new DateTime();
        $this->closingDate = new DateTime();

        $this->round->setRoundNumber(1)
             ->setRoundStartDate($this->date)
             ->setMonthlyCotisation(100000.00)
             ->setMonthlyCaisseSociale(2000.00)
             ->setLoanMonthsDuration(6)
             ->setLoanMonthlyInterestPercentage(1)
             ->setLoanPrincipalGracePeriod(1)
             ->setLoanInterestGracePeriod(1)
             ->setInterestLatePenalityPercentage(1)
             ->setMeetingLatePenalityAmount(3000)
             ->setMeetingAbsencePenalityAmount(5000)
             ->setMeetingFrequency('30')
             ->setMeetingStartHour('15:00')
             ->setStatus('future')
             ->setTotalMeetings(10)
             ->setRoundClosingDate($this->closingDate);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->round->getRoundNumber() === 1);
        $this->assertTrue($this->round->getRoundStartDate() === $this->date);
        $this->assertTrue($this->round->getMonthlyCotisation() === 100000.00);
        $this->assertTrue($this->round->getMonthlyCaisseSociale() === 2000.00);
        $this->assertTrue($this->round->getLoanMonthsDuration() === 6);
        $this->assertTrue($this->round->getLoanMonthlyInterestPercentage() === 1.0);
        $this->assertTrue($this->round->getLoanPrincipalGracePeriod() === 1);
        $this->assertTrue($this->round->getLoanInterestGracePeriod() === 1);
        $this->assertTrue($this->round->getInterestLatePenalityPercentage() === 1.0);
        $this->assertTrue($this->round->getMeetingLatePenalityAmount() === 3000.00);
        $this->assertTrue($this->round->getMeetingAbsencePenalityAmount() === 5000.00);
        $this->assertTrue($this->round->getMeetingFrequency() === '30');
        $this->assertTrue($this->round->getMeetingStartHour() === '15:00');
        $this->assertTrue( $this->round->getStatus() === 'future');
        $this->assertTrue( $this->round->getTotalMeetings() === 10);
        $this->assertTrue( $this->round->getRoundClosingDate() === $this->closingDate);
    }
    
    public function testIsFalse()
    {
        $this->round->setRoundNumber(1)
             ->setRoundStartDate($this->date)
             ->setMonthlyCotisation(100000.00)
             ->setMonthlyCaisseSociale(2000.00)
             ->setLoanMonthsDuration(6)
             ->setLoanMonthlyInterestPercentage(1)
             ->setLoanPrincipalGracePeriod(1)
             ->setLoanInterestGracePeriod(1)
             ->setInterestLatePenalityPercentage(1)
             ->setMeetingLatePenalityAmount(3000)
             ->setMeetingAbsencePenalityAmount(5000)
             ->setMeetingFrequency(30)
             ->setMeetingStartHour('15:00')
             ->setStatus('future')
             ->setTotalMeetings(10)
             ->setRoundClosingDate(null);

        $this->assertFalse($this->round->getRoundNumber() === 0);
        $this->assertFalse($this->round->getRoundStartDate() != $this->date);
        $this->assertFalse($this->round->getMonthlyCotisation() === 90000.00);
        $this->assertFalse($this->round->getMonthlyCaisseSociale() === 2200.00);
        $this->assertFalse($this->round->getLoanMonthsDuration() === 5);
        $this->assertFalse($this->round->getLoanMonthlyInterestPercentage() === 0);
        $this->assertFalse($this->round->getLoanPrincipalGracePeriod() === 0);
        $this->assertFalse($this->round->getLoanInterestGracePeriod() === 0);
        $this->assertFalse($this->round->getInterestLatePenalityPercentage() === 0);
        $this->assertFalse($this->round->getMeetingLatePenalityAmount() === 3300);
        $this->assertFalse($this->round->getMeetingAbsencePenalityAmount() === 5500);
        $this->assertFalse($this->round->getMeetingFrequency() === 33);
        $this->assertFalse($this->round->getMeetingStartHour() === '15:10');
        $this->assertFalse($this->round->getStatus() === 'futur');
        $this->assertFalse($this->round->getTotalMeetings() === 5);
        $this->assertFalse($this->round->getRoundClosingDate() === $this->closingDate);
    }

    public function testIsEmpty()
    {
        $this->round = new Round();

        $this->assertEmpty($this->round->getId());
        $this->assertEmpty($this->round->getRoundNumber());
        $this->assertEmpty($this->round->getRoundStartDate());
        $this->assertEmpty($this->round->getMonthlyCotisation());
        $this->assertEmpty($this->round->getMonthlyCaisseSociale());
        $this->assertEmpty($this->round->getLoanMonthsDuration());
        $this->assertEmpty($this->round->getLoanMonthlyInterestPercentage());        
        $this->assertEmpty($this->round->getLoanPrincipalGracePeriod());
        $this->assertEmpty($this->round->getLoanInterestGracePeriod());
        $this->assertEmpty($this->round->getInterestLatePenalityPercentage());
        $this->assertEmpty($this->round->getMeetingLatePenalityAmount());
        $this->assertEmpty($this->round->getMeetingAbsencePenalityAmount());
        $this->assertEmpty($this->round->getMeetingFrequency());
        $this->assertEmpty($this->round->getMeetingStartHour());
        $this->assertEmpty( $this->round->getStatus());       
        $this->assertEmpty( $this->round->getTotalMeetings());      
        $this->assertEmpty( $this->round->getRoundClosingDate());      
    }

    public function testAddGetRemoveMeeting()
    {
        $this->round = new Round();
        $meeting = new Meeting();

        $this->assertEmpty($this->round->getmeetings());

        $this->round->addMeeting($meeting);
        $this->assertContains($meeting, $this->round->getMeetings());

        $this->round->removeMeeting($meeting);
        $this->assertEmpty($this->round->getMeetings());
    }
}
