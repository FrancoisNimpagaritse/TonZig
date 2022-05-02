<?php

namespace App\Tests;

use App\Entity\AppliedSanction;
use App\Entity\Assistance;
use App\Entity\CaisseSociale;
use App\Entity\Cotisation;
use App\Entity\Loan;
use App\Entity\Meeting;
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

        $this->assertEmpty($user->getId());
        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastname());
        $this->assertEmpty($user->getAddress());
        $this->assertEmpty($user->getPhone());
        $this->assertEmpty($user->getRegisteredAt());
        $this->assertEmpty($user->getStatus());
        $this->assertEmpty($user->getSuspendedAt());
        $this->assertEmpty($user->getUsername());
        $this->assertNull($user->getSalt());
        $this->assertEquals(1, count($user->getRoles()));
    }

    public function testAddGetRemoveCotisation()
    {
        $member = new User();
        $cotisation = new Cotisation();

        $this->assertEmpty($member->getCotisations());

        $member->addCotisation($cotisation);
        $this->assertContains($cotisation, $member->getCotisations());

        $member->removeCotisation($cotisation);
        $this->assertEmpty($member->getCotisations());
    }

    public function testAddGetRemoveCaisse()
    {
        $member = new User();
        $caisse = new CaisseSociale();

        $this->assertEmpty($member->getCaisseSociales());

        $member->addCaisseSociale($caisse);
        $this->assertContains($caisse, $member->getCaisseSociales());

        $member->removeCaisseSociale($caisse);
        $this->assertEmpty($member->getCaisseSociales());
    }

    public function testAddGetRemoveLoan()
    {
        $member = new User();
        $loan= new Loan();

        $this->assertEmpty($member->getLoans());

        $member->addLoan($loan);
        $this->assertContains($loan, $member->getLoans());

        $member->removeLoan($loan);
        $this->assertEmpty($member->getLoans());
    }

    public function testAddGetRemoveAssistance()
    {
        $member = new User();
        $assistance = new Assistance();

        $this->assertEmpty($member->getAssistances());

        $member->addAssistance($assistance);
        $this->assertContains($assistance, $member->getAssistances());

        $member->removeAssistance($assistance);
        $this->assertEmpty($member->getAssistances());
    }

    public function testAddGetRemoveSanction()
    {
        $member = new User();
        $sanction = new AppliedSanction();

        $this->assertEmpty($member->getSanctions());

        $member->addSanction($sanction);
        $this->assertContains($sanction, $member->getSanctions());

        $member->removeSanction($sanction);
        $this->assertEmpty($member->getSanctions());
    }

    public function testAddGetRemoveHostedOneMeeting()
    {
        $member = new User();
        $meeting = new Meeting();

        $this->assertEmpty($member->getHostedOneMeetings());

        $member->addHostedOneMeeting($meeting);
        $this->assertContains($meeting, $member->getHostedOneMeetings());

        $member->removeHostedOneMeeting($meeting);
        $this->assertEmpty($member->getHostedOneMeetings());
    }

    public function testAddGetRemoveHostedTwoMeeting()
    {
        $member = new User();
        $meeting = new Meeting();

        $this->assertEmpty($member->getSanctions());

        $member->addHostedTwoMeeting($meeting);
        $this->assertContains($meeting, $member->getHostedTwoMeetings());

        $member->removeHostedTwoMeeting($meeting);
        $this->assertEmpty($member->getHostedTwoMeetings());
    }
}
