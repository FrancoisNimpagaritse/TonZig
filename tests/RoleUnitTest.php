<?php

namespace App\Tets;

use App\Entity\Role;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class RoleUnitTest extends TestCase
{
    /** @var Role */
    private $role;

    public function setUp(): void
    {
        $this->role = new Role();

        $this->role->setTitle('Tester');
    }

    public function testIsTrue()
    {
        $this->assertTrue($this->role->getTitle() === 'Tester');
    }
    
    public function testIsFalse()
    {
        $this->role->setTitle('Owner');

        $this->assertFalse($this->role->getTitle() === 'Tester');
    }

    public function testIsEmpty()
    {
        $this->role = new Role();

        $this->assertEmpty($this->role->getId());
        $this->assertEmpty($this->role->getTitle());
    }

    public function testAddGetRemoveUser()
    {
        $this->role = new Role();
        $member = new User();

        $this->assertEmpty($this->role->getUsers());

        $this->role->addUser($member);
        $this->assertContains($member, $this->role->getUsers());

        $this->role->removeUser($member);
        $this->assertEmpty($this->role->getUsers());
    }
}