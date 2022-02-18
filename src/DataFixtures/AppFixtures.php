<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        //Ici nous gérons les meetings       


        $manager->flush();
    }
}
