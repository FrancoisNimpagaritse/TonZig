<?php

namespace App\Tests;

use DateTime;
use App\Entity\Loan;
use App\Entity\LoanPayment;
use PHPUnit\Framework\TestCase;

class LoanPaymentUnitTest extends TestCase
{
    private $loan;
    private $loanRepay;
    private $date;
    private $member;
    private $meeting;

    public function setUp(): void
    {
        $this->loan = new Loan();
        $this->loanRepay = new LoanPayment();
        $this->date = new DateTime();

        $this->loanRepay->setPaidDate($this->date)
                    ->setPrincipal(200000.00)
                    ->setInterest(5000)
                    ->setPenality(0)
                    ->setLoan($this->loan);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->loanRepay->getPaidDate() === $this->date);
        $this->assertTrue($this->loanRepay->getPrincipal() == 200000);
        $this->assertTrue($this->loanRepay->getInterest() == 5000);
        $this->assertTrue($this->loanRepay->getPenality() == 0);
        $this->assertTrue($this->loanRepay->getLoan() === $this->loan);
    }
    
    public function testIsFalse()
    {
        $this->loanRepay->setPaidDate($this->date)
                    ->setPrincipal(1000000.00)
                    ->setInterest(5000)
                    ->setPenality(0)
                    ->setLoan($this->loan);

        $this->assertFalse($this->loanRepay->getPaidDate() != $this->date);
        $this->assertFalse($this->loanRepay->getPrincipal() === 90000.00);
        $this->assertFalse($this->loanRepay->getInterest() === 4200);
        $this->assertFalse($this->loanRepay->getPenality() === 1);
        $this->assertFalse($this->loanRepay->getLoan() !== $this->loan);
    }

    public function testIsEmpty()
    {
        $this->loanRepay = new LoanPayment();

        $this->assertEmpty($this->loanRepay->getPaidDate());
        $this->assertEmpty($this->loanRepay->getPrincipal());
        $this->assertEmpty($this->loanRepay->getInterest());
        $this->assertEmpty($this->loanRepay->getPenality());
        $this->assertEmpty($this->loanRepay->getLoan());
    }
}
