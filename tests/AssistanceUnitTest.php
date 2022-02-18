<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Assistance;
use PHPUnit\Framework\TestCase;

class AssistanceUnitTest extends TestCase
{
    private $assist;
    private $member;
    private $date;

    public function setUp(): void
    {
        $this->assist = new Assistance();
        $this->member = new User();
        $this->date = new DateTime();

        $this->assist->setDistributedDate($this->date)
                    ->setAmount(50000.00)
                    ->setBeneficiary($this->member)
                    ->setReason('Hospitalisation');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->assist->getDistributedDate() === $this->date);
        $this->assertTrue($this->assist->getAmount() === 50000.00);
        $this->assertTrue($this->assist->getBeneficiary() === $this->member);
        $this->assertTrue($this->assist->getReason() === 'Hospitalisation');
    }
    
    public function testIsFalse()
    {
        $this->assist->setDistributedDate($this->date)
                    ->setAmount(1000000.00)
                    ->setBeneficiary($this->member)
                    ->setReason('Hospitalisation');

        $this->assertFalse($this->assist->getDistributedDate() === (new DateTime()));
        $this->assertFalse($this->assist->getAmount() === 90000.00);
        $this->assertFalse($this->assist->getBeneficiary() === new User());
        $this->assertFalse($this->assist->getReason() === 'Hospital');
    }

    public function testIsEmpty()
    {
        $this->assist = new Assistance();

        $this->assertEmpty($this->assist->getDistributedDate());
        $this->assertEmpty($this->assist->getAmount());
        $this->assertEmpty($this->assist->getBeneficiary());
        $this->assertEmpty($this->assist->getReason());
    }
}