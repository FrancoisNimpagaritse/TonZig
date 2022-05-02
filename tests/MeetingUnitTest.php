<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Round;
use App\Entity\Meeting;
use App\Entity\Cotisation;
use App\Entity\CaisseSociale;
use App\Entity\AppliedSanction;
use App\Entity\Loan;
use PHPUnit\Framework\TestCase;
use App\Entity\MeetingLotDistribution;

class MeetingUnitTest extends TestCase
{
    /** @var Meeting */
    private $meeting;
    private $date;
    private $round; 
    private $loan; 
    private $lot;
    private $cotisation;
    private $caisseSoc;
    private $sanction;
    private $mem1;
    private $mem2;

    public function setUp(): void
    {
        $this->meeting = new Meeting();
        $this->round = new Round();
        $this->date = new DateTime();
        $this->lot = new MeetingLotDistribution();
        $this->cotisation = new Cotisation();
        $this->caisseSoc = new CaisseSociale();
        $this->sanction = new AppliedSanction();
        $this->mem1 = new User();
        $this->mem2 = new User();
        $this->round = new Round();


        $this->meeting->setMeetingAt($this->date)
             ->setRemainingMeetings(9)
             ->setHostOne($this->mem1)
             ->setHostTwo($this->mem2)
             ->setLotDistribution($this->lot)
             ->addCotisation($this->cotisation)
             ->addCaisseSociale($this->caisseSoc)
             ->addAppliedSanction($this->sanction)
             ->setRound($this->round);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->meeting->getMeetingAt() === $this->date);
        $this->assertTrue($this->meeting->getRemainingMeetings() === 9);
        $this->assertTrue($this->meeting->getLotDistribution() === $this->lot);
        $this->assertTrue($this->meeting->getHostOne() === $this->mem1);
        $this->assertTrue($this->meeting->getHostTwo() === $this->mem2);
        $this->assertTrue($this->meeting->getRound() === $this->round);
        $this->assertCount(1, $this->meeting->getCotisations());
        $this->assertCount(1, $this->meeting->getCaisseSociales());
        $this->assertCount(1, $this->meeting->getAppliedSanctions());

        $this->meeting->removeCotisation($this->cotisation);
        $this->meeting->removeCaisseSociale($this->caisseSoc);
        $this->meeting->removeAppliedSanction($this->sanction);

        $this->assertCount(0, $this->meeting->getCotisations());
        $this->assertCount(0, $this->meeting->getCaisseSociales());
        $this->assertCount(0, $this->meeting->getAppliedSanctions());
    }
    
    public function testIsFalse()
    {
        $this->meeting->setMeetingAt($this->date)
        ->setRemainingMeetings(9)
        ->setHostOne($this->mem1)
        ->setHostTwo($this->mem2)
        ->setLotDistribution($this->lot)
        ->addCotisation($this->cotisation)
        ->addCaisseSociale($this->caisseSoc)
        ->addAppliedSanction($this->sanction);        

        $this->assertFalse($this->meeting->getMeetingAt() !== $this->date);
        $this->assertFalse($this->meeting->getRemainingMeetings() === 0);
        $this->assertFalse($this->meeting->getLotDistribution() !== $this->lot);
        $this->assertFalse($this->meeting->getHostOne() !== $this->mem1);
        $this->assertFalse($this->meeting->getHostTwo() !== $this->mem2);
        $this->assertFalse(0 === count($this->meeting->getCotisations()));
        $this->assertFalse(0 === count($this->meeting->getCaisseSociales()));
        $this->assertFalse(0 === count($this->meeting->getAppliedSanctions()));
    }

    public function testIsEmpty()
    {
        $this->meeting = new Meeting();

        $this->assertEmpty($this->meeting->getId());
        $this->assertEmpty($this->meeting->getMeetingAt());
        $this->assertEmpty($this->meeting->getRemainingMeetings());
        $this->assertEmpty($this->meeting->getLotDistribution());
        $this->assertEmpty($this->meeting->getHostOne());
        $this->assertEmpty($this->meeting->getHostTwo());
        $this->assertEmpty($this->meeting->getCotisations());
        $this->assertEmpty($this->meeting->getCaisseSociales());
        $this->assertEmpty($this->meeting->getAppliedSanctions());
        $this->assertEmpty($this->meeting->getRound());
    }

    public function testAddGetRemoveLoan()
    {
        $this->loan = new Loan();        
        $this->meeting = new Meeting();

        $this->assertEmpty($this->meeting->getLoans());

        $this->meeting->addLoan($this->loan);
        $this->assertContains($this->loan, $this->meeting->getLoans());

        $this->meeting->removeLoan($this->loan);
        $this->assertEmpty($this->meeting->getLoans());
    }
}
