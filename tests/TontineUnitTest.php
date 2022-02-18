<?php

namespace App\Tests;

use DateTime;
use App\Entity\Tontine;
use PHPUnit\Framework\TestCase;

class TontineUnitTest extends TestCase
{
    private $tontine;
    private $date;

    public function setUp(): void
    {
        $this->tontine = new Tontine();
        $this->date = new DateTime();

        $this->tontine->setName('Association Bene Umwizero')
             ->setCreatedAt($this->date)
             ->setAddressSiegeSocial('Mukaza Bujumbura')
             ->setCurrency('BIF')
             ->setSlogan('Ensemble nous sommes forts!')
             ->setDescription('Une association de soutien')
             ->setType('Tontine');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->tontine->getName() === 'Association Bene Umwizero');
        $this->assertTrue($this->tontine->getCreatedAt() === $this->date);
        $this->assertTrue($this->tontine->getAddressSiegeSocial() === 'Mukaza Bujumbura');
        $this->assertTrue($this->tontine->getCurrency() === 'BIF');
        $this->assertTrue($this->tontine->getSlogan() === 'Ensemble nous sommes forts!');
        $this->assertTrue($this->tontine->getDescription() === 'Une association de soutien');
        $this->assertTrue($this->tontine->getType() === 'Tontine');
    }
    
    public function testIsFalse()
    {
        $this->tontine->setName('')
                    ->setCreatedAt(new DateTime())
                    ->setAddressSiegeSocial('')
                    ->setCurrency('')
                    ->setSlogan('')
                    ->setDescription('')
                    ->setType('');

             $this->assertFalse($this->tontine->getName() === 'Association Umwizero');
             $this->assertFalse($this->tontine->getCreatedAt() === $this->date);
             $this->assertFalse($this->tontine->getAddressSiegeSocial() === 'Mukaza II Bujumbura');
             $this->assertFalse($this->tontine->getCurrency() === 'Fbu');
             $this->assertFalse($this->tontine->getSlogan() === 'Nous sommes forts!');
             $this->assertFalse($this->tontine->getDescription() === 'Une association sans soutien');
             $this->assertFalse($this->tontine->getType() === 'Tontin');
    }

    public function testIsEmpty()
    {
        $this->tontine = new Tontine();

        $this->assertEmpty($this->tontine->getName());
        $this->assertEmpty($this->tontine->getCreatedAt());
        $this->assertEmpty($this->tontine->getAddressSiegeSocial());
        $this->assertEmpty($this->tontine->getCurrency());
        $this->assertEmpty($this->tontine->getSlogan());
        $this->assertEmpty($this->tontine->getDescription());
        $this->assertEmpty($this->tontine->getType());
    }
}
