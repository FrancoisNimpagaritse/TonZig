<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use DateTime;

class UserUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $user = new User();
        $date = new DateTime();

        $user->setEmail('john@tonzig.franimpa.fr')
             ->setFirstname('John')
             ->setLastname('Mugwiza')
             ->setPassword('password')
             ->setAddress('Kigobe, avenue Kiganda, n°11')
             ->setPhone('+257 79 555 555')
             ->setRegisteredAt($date)
             ->setStatus('Actif')
             ->setSuspendedAt(null);

        $this->assertTrue($user->getEmail() === 'john@tonzig.franimpa.fr');
        $this->assertTrue($user->getFirstname() === 'John');
        $this->assertTrue($user->getLastname() === 'Mugwiza');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getAddress() === 'Kigobe, avenue Kiganda, n°11');
        $this->assertTrue($user->getPhone() === '+257 79 555 555');
        $this->assertTrue($user->getRegisteredAt() === $date);
        $this->assertTrue($user->getStatus() === 'Actif');
        $this->assertTrue($user->getSuspendedAt() === null);

    }
    
    public function testIsFalse()
    {
        $user = new User();
        $date = new DateTime();

        $user->setEmail('true@tonzig.franimpa.fr')
             ->setFirstname('John')
             ->setLastname('Mugwiza')
             ->setPassword('test')
             ->setAddress('Kigobe, avenue Kiganda, n°11')
             ->setPhone('+257 79 555 555')
             ->setRegisteredAt($date)
             ->setStatus('Actif')
             ->setSuspendedAt(null);

             $this->assertFalse($user->getEmail() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getFirstname() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getLastname() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getPassword() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getAddress() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getPhone() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getRegisteredAt() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getStatus() === 'john@tonzig.franimpa.fr');
             $this->assertFalse($user->getSuspendedAt() === $date);
    }

    public function testIsEmpty()
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        //$this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getAddress());
        $this->assertEmpty($user->getPhone());
        $this->assertEmpty($user->getRegisteredAt());
        $this->assertEmpty($user->getStatus());
        $this->assertEmpty($user->getSuspendedAt());
    }
}
