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
                    ->setPrincipalDue(200000.00)
                    ->setInterestDue(5000)
                    ->setPenalityDue(0)
                    ->setLoan($this->loan);
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->loanDue->getDueDate() === $this->date);
        $this->assertTrue($this->loanDue->getPrincipalDue() === 200000.00);
        $this->assertTrue($this->loanDue->getInterestDue() === 5000.00);
        $this->assertTrue($this->loanDue->getPenalityDue() === 0.00);
        $this->assertTrue($this->loanDue->getLoan() === $this->loan);
    }
    
    public function testIsFalse()
    {
        $this->loanDue->setDueDate($this->date)
                    ->setPrincipalDue(1000000.00)
                    ->setInterestDue(5000)
                    ->setPenalityDue(0)
                    ->setLoan($this->loan);

        $this->assertFalse($this->loanDue->getDueDate() != $this->date);
        $this->assertFalse($this->loanDue->getPrincipalDue() === 90000.00);
        $this->assertFalse($this->loanDue->getInterestDue() === 4200);
        $this->assertFalse($this->loanDue->getPenalityDue() === 1);
        $this->assertFalse($this->loanDue->getLoan() !== $this->loan);
    }

    public function testIsEmpty()
    {
        $this->loanDue = new LoanDue();

        $this->assertEmpty($this->loanDue->getDueDate());
        $this->assertEmpty($this->loanDue->getPrincipalDue());
        $this->assertEmpty($this->loanDue->getInterestDue());
        $this->assertEmpty($this->loanDue->getPenalityDue());
        $this->assertEmpty($this->loanDue->getLoan());
    }
}
