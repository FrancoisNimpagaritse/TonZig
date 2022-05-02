<?php

namespace App\Tets;

use App\Entity\Account;
use App\Entity\MouvementCaisse;
use PHPUnit\Framework\TestCase;

class AccountUnitTest extends TestCase
{
    /** @var Account */
    private $account;

    public function setUp(): void
    {
        $this->account = new Account();

        $this->account->setNumber('100')
                    ->setLabel('Compte de test');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->account->getNumber() === '100');
        $this->assertTrue($this->account->getLabel() === 'Compte de test');
    }
    
    public function testIsFalse()
    {
        $this->account->setNumber('200')
                    ->setLabel('Compte ok');

        $this->assertFalse($this->account->getNumber() === '100');
        $this->assertFalse($this->account->getLabel() === 'Compte');
    }

    public function testIsEmpty()
    {
        $this->account = new Account();

        $this->assertEmpty($this->account->getId());
        $this->assertEmpty($this->account->getNumber());
        $this->assertEmpty($this->account->getLabel());
    }

    public function testAddGetRemoveTransactionCaisse()
    {
        $this->account = new Account();        
        $transaction = new MouvementCaisse();

        $this->assertEmpty($this->account->getTransactions());

        $this->account->addTransaction($transaction);
        $this->assertContains($transaction, $this->account->getTransactions());

        $this->account->removeTransaction($transaction);
        $this->assertEmpty($this->account->getTransactions());
    }
}