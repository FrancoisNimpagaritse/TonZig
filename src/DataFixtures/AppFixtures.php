<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Meeting;
use App\Entity\User;
use App\Repository\MeetingRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        
        //Ici nous gérons les membres
        $members = [];
        for($i = 0; $i < 10; $i++){
            $mem = new User();

            $mem->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword("password")
                ->setRegisteredAt($faker->dateTimeBetween('-5 years', '-1 years'))
                ->setAddress($faker->streetAddress)
                ->setPostalcode($faker->postcode)
                ->setPhone($faker->phoneNumber)
                ->setResidenceCountry($country_residence)
                ->setNationalityCountry($country_nationality);

            $manager->persist($mem);

            $members[] = $mem;

        }
        //Ici nous gérons les cotisations

        //Ici nous gérons les caissesociales
        //Ici nous gérons les lots
        //Ici nous gérons les sanctions
        //Ici nous gérons les crédits
        //Ici nous gérons les rembursements
        //Ici nous gérons les assistances


        $manager->flush();
    }
}
