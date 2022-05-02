<?php

namespace App\Tests;

use DateTime;
use App\Entity\Loan;
use App\Entity\LoanDue;
use App\Entity\LoanPayment;
use App\Entity\Meeting;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class LoanUnitTest extends TestCase
{
    /** @var Loan */
    private $loan;
    private $date;
    private $member;
    private $meeting;

    public function setUp(): void
    {
        $this->loan = new Loan();
        $this->date = new DateTime();
        $this->member = new User();
        $this->meeting = new Meeting();

        $this->loan->setDisbursedAt($this->date)
                    ->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setStatus('Encours')
                    ->setDuration(6);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->loan->getDisbursedAt() === $this->date);
        $this->assertTrue($this->loan->getAmount() == 1000000);
        $this->assertTrue($this->loan->getMember() === $this->member);
        $this->assertTrue($this->loan->getMeeting() === $this->meeting);
        $this->assertTrue($this->loan->getStatus() === 'Encours');
        $this->assertTrue($this->loan->getDuration() === 6);
    }
    
    public function testIsFalse()
    {
        $this->loan->setDisbursedAt($this->date)
                    ->setAmount(1000000.00)
                    ->setMember($this->member)
                    ->setMeeting($this->meeting)
                    ->setStatus('Encours')
                    ->setDuration(5);

        $this->assertFalse($this->loan->getDisbursedAt() != $this->date);
        $this->assertFalse($this->loan->getAmount() === 90000.00);
        $this->assertFalse($this->loan->getMember() === new User());
        $this->assertFalse($this->loan->getMeeting() === new Meeting());
        $this->assertFalse($this->loan->getStatus() === 'cours');
        $this->assertFalse($this->loan->getDuration() === 6);
    }

    public function testIsEmpty()
    {
        $this->loan = new Loan();

        $this->assertEmpty($this->loan->getId());
        $this->assertEmpty($this->loan->getDisbursedAt());
        $this->assertEmpty($this->loan->getAmount());
        $this->assertEmpty($this->loan->getMember());
        $this->assertEmpty($this->loan->getMeeting());
        $this->assertEmpty($this->loan->getStatus());
        $this->assertEmpty($this->loan->getDuration());
        $this->assertEmpty($this->loan->getTotalPrincipalPaid());
        $this->assertEmpty($this->loan->getTotalInterestPaid());

    }

    public function testAddGetRemovePayment()
    {
        $this->loan = new Loan();        
        $pay = new LoanPayment();

        $this->assertEmpty($this->loan->getPayments());

        $this->loan->addPayment($pay);
        $this->assertContains($pay, $this->loan->getPayments());

        $this->loan->removePayment($pay);
        $this->assertEmpty($this->loan->getPayments());
    }

    public function testAddGetRemoveDue()
    {
        $this->loan = new Loan();        
        $due = new LoanDue();

        $this->assertEmpty($this->loan->getDues());

        $this->loan->addDue($due);
        $this->assertContains($due, $this->loan->getDues());

        $this->loan->removeDue($due);
        $this->assertEmpty($this->loan->getDues());
    }
}
