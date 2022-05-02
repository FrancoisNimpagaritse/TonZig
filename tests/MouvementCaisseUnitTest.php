<?php

namespace App\Tets;

use DateTime;
use App\Entity\User;
use App\Entity\Account;
use App\Entity\MouvementCaisse;
use PHPUnit\Framework\TestCase;

class MouvementCaisseUnitTest extends TestCase
{
    /** @var MouvementCaisse */
    private $mouvement;
    private $date;
    private $account;

    public function setUp(): void
    {
        $this->mouvement = new MouvementCaisse();
        $this->date = new DateTime();
        $this->account = new Account();

        $this->mouvement->setTransactionDate($this->date)
                        ->setAccount($this->account)
                        ->setAmount(1)
                        ->setType('entrée')
                        ->setDescription('Une description de test')
                        ->setOriginCode('Cotis');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->mouvement->getTransactionDate() === $this->date);
        $this->assertTrue($this->mouvement->getAccount() === $this->account);
        $this->assertTrue($this->mouvement->getAmount() === 1.00);
        $this->assertTrue($this->mouvement->getType() === 'entrée');
        $this->assertTrue($this->mouvement->getDescription() === 'Une description de test');
        $this->assertTrue($this->mouvement->getOriginCode() === 'Cotis');
    }
    
    public function testIsFalse()
    {
        $this->assertFalse($this->mouvement->getTransactionDate() !== $this->date);
        $this->assertFalse($this->mouvement->getAccount() !== $this->account);
        $this->assertFalse($this->mouvement->getAmount() === 2);
        $this->assertFalse($this->mouvement->getType() === 'sortie');
        $this->assertFalse($this->mouvement->getDescription() === 'Une description');
        $this->assertFalse($this->mouvement->getOriginCode() === 'Cotisa');
    }

    public function testIsEmpty()
    {
        $this->mouvement = new MouvementCaisse();

        $this->assertEmpty($this->mouvement->getId());
        $this->assertEmpty($this->mouvement->getTransactionDate());
        $this->assertEmpty($this->mouvement->getAccount());
        $this->assertEmpty($this->mouvement->getAmount());
        $this->assertEmpty($this->mouvement->getType());
        $this->assertEmpty($this->mouvement->getDescription());
        $this->assertEmpty($this->mouvement->getOriginCode());
    }
}