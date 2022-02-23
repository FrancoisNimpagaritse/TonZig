<?php

namespace App\Tests;

use DateTime;
use App\Entity\Loan;
use App\Entity\LoanDue;
use PHPUnit\Framework\TestCase;

class LoanDueUnitTest extends TestCase
{
    private $loan;
    private $loanDue;
    private $date;

    public function setUp(): void
    {
        $this->loan = new Loan();
        $this->loanDue = new LoanDue();
        $this->date = new DateTime();

        $this->loanDue->setDueDate($this->date)
                    ->setPrincipal(200000.00)
                    ->setInterest(5000)
                    ->setPenality(0)
                    ->setLoan($this->loan);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->loanDue->getDueDate() === $this->date);
        $this->assertTrue($this->loanDue->getPrincipal() === 200000.00);
        $this->assertTrue($this->loanDue->getInterest() === 5000.00);
        $this->assertTrue($this->loanDue->getPenality() === 0.00);
        $this->assertTrue($this->loanDue->getLoan() === $this->loan);
    }
    
    public function testIsFalse()
    {
        $this->loanDue->setDueDate($this->date)
                    ->setPrincipal(1000000.00)
                    ->setInterest(5000)
                    ->setPenality(0)
                    ->setLoan($this->loan);

        $this->assertFalse($this->loanDue->getDueDate() != $this->date);
        $this->assertFalse($this->loanDue->getPrincipal() === 90000.00);
        $this->assertFalse($this->loanDue->getInterest() === 4200);
        $this->assertFalse($this->loanDue->getPenality() === 1);
        $this->assertFalse($this->loanDue->getLoan() !== $this->loan);
    }

    public function testIsEmpty()
    {
        $this->loanDue = new LoanDue();

        $this->assertEmpty($this->loanDue->getDueDate());
        $this->assertEmpty($this->loanDue->getPrincipal());
        $this->assertEmpty($this->loanDue->getInterest());
        $this->assertEmpty($this->loanDue->getPenality());
        $this->assertEmpty($this->loanDue->getLoan());
    }
}
