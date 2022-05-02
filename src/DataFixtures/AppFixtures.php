<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\AppliedSanction;
use App\Entity\Assistance;
use App\Entity\CaisseSociale;
use App\Entity\Cotisation;
use App\Entity\Loan;
use App\Entity\LoanDue;
use App\Entity\LoanPayment;
use App\Entity\Meeting;
use App\Entity\MeetingLotDistribution;
use App\Entity\MouvementCaisse;
use App\Entity\Role;
use App\Entity\Round;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //Ici nous gérons les rounds
        $round = new Round();
        $round->setRoundNumber(1)
            ->setStatus('ouvert')
            ->setRoundStartDate($faker->dateTimeBetween('-1 years', '0 years'))
            ->setMonthlyCotisation(100000)
            ->setMonthlyCaisseSociale(2000)
            ->setLoanMonthsDuration(6)
            ->setLoanMonthlyInterestPercentage(1)
            ->setLoanPrincipalGracePeriod(1)
            ->setLoanInterestGracePeriod(0)
            ->setPrincipalLatePenalityPercentage(1)
            ->setInterestLatePenalityPercentage(1)
            ->setMeetingLatePenalityAmount(2000)
            ->setMeetingAbsencePenalityAmount(5000)
            ->setMeetingFrequency(30)
            ->setMeetingStartHour('15:00')
            ->setTotalMeetings(10);

        $manager->persist($round);

        //Ici nous gérons les rôles Admin
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');

        $manager->persist($adminRole);

         //Ici nous gérons les rôles Finance
         $finaRole = new Role();
         $finaRole->setTitle('ROLE_FINANCE');
 
         $manager->persist($finaRole);

        //Ici nous gérons le user qui a le rôle Admin
        $adminUser = new User();
        $hash = $this->encoder->encodePassword($adminUser, 'password');

            $adminUser->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail('admin@test.com')
                ->setPassword($hash)
                ->setRegisteredAt($faker->dateTimeBetween('-5 years', '-1 years'))
                ->setAddress($faker->streetAddress)
                ->setPhone($faker->phoneNumber)
                ->setIsVerified(true)
                ->setStatus('actif')
                ->addUserRole($adminRole);

            $manager->persist($adminUser);

         //Ici nous gérons le user qui a le rôle Finance
         $finaUser = new User();
         $hash = $this->encoder->encodePassword($finaUser, 'password');
 
             $finaUser->setFirstname($faker->firstName())
                 ->setLastname($faker->lastName)
                 ->setEmail('fina@test.com')
                 ->setPassword($hash)
                 ->setRegisteredAt($faker->dateTimeBetween('-5 years', '-1 years'))
                 ->setAddress($faker->streetAddress)
                 ->setPhone($faker->phoneNumber)
                 ->setIsVerified(true)
                 ->setStatus('actif')
                 ->addUserRole($finaRole);
 
             $manager->persist($finaUser);

        //Ici nous gérons les membres
        $members = [];
        for ($i = 0; $i < 20; ++$i) {
            $mem = new User();

            $hash = $this->encoder->encodePassword($mem, 'password');

            $mem->setFirstname($faker->firstName())
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($hash)
                ->setRegisteredAt($faker->dateTimeBetween('-5 years', '-1 years'))
                ->setAddress($faker->streetAddress)
                ->setPhone($faker->phoneNumber)
                ->setIsVerified(false)
                ->setStatus('actif');

            $manager->persist($mem);

            $members[] = $mem;
        }

        //Ici nous gérons les meetings
        $meetings = [];
        for ($i = 0; $i < 10; ++$i) {
            $meeting = new Meeting();

            $meeting->setMeetingAt($faker->dateTimeBetween('0 years', '1 years'))
                    ->setRemainingMeetings(9 - $i)
                    ->setRound($round)
                    ->setHostOne($members[mt_rand(0, 9)])
                    ->setHostTwo($members[mt_rand(10, 19)]);

            $manager->persist($meeting);
            $meetings[] = $meeting;
        }

        //Ici nous gérons les cotisations
        for ($i = 0; $i < 5; ++$i) {
            $cotis = new Cotisation();

            $cotis->setAmount(100000)
                ->setNote('payé')
                ->setMeeting($meetings[mt_rand(0, 5)])
                ->setMember($members[mt_rand(0, 19)]);

            $manager->persist($cotis);
        }

        //Ici nous gérons les caissesociales
        for ($i = 0; $i < 5; ++$i) {
            $caisse = new CaisseSociale();

            $caisse->setAmount(2000)
                ->setNote('payé')
                ->setMeeting($meetings[mt_rand(0, 5)])
                ->setMember($members[mt_rand(0, 19)]);

            $manager->persist($caisse);
        }

        //Ici nous gérons les lots
        for ($i = 0; $i < 5; ++$i) {
            $lot = new MeetingLotDistribution();

            $lot->setAmount(1000000)
                ->setMeeting($meetings[$i])
                ->setBeneficiaires($members[$i].' et '.$members[$i + 10]);

            $manager->persist($lot);
        }

        //Ici nous gérons les sanctions
        for ($i = 0; $i < 5; ++$i) {
            $sanction = new AppliedSanction();

            $sanctionTypes = ['Retard', 'Absence'];
            $meet = $meetings[mt_rand(0, 5)];

            $sanction->setAmount(10000)
                ->setMeeting($meet)
                ->setMember($members[mt_rand(0, 9)])
                ->setSanctionType($sanctionTypes[mt_rand(0, 1)]);

            $manager->persist($sanction);
        }
        //Ici nous gérons les crédits
        $loans = [];
        for ($i = 0; $i < 15; ++$i) {
            $loan = new Loan();

            $meet = $meetings[mt_rand(0, 5)];

            $loan->setDisbursedAt($meet->getMeetingAt())
                ->setDuration(mt_rand(1, 6))
                ->setAmount(1000000)
                ->setMeeting($meetings[mt_rand(0, 5)])
                ->setMember($members[mt_rand(0, 9)])
                ->setStatus('encours');

            $manager->persist($loan);
            $loans[] = $loan;
        }

        //Ici nous gérons les dues de crédits
        for ($i = 0; $i < 15; ++$i) {
            $due = new LoanDue();

            $loan = $loans[mt_rand(0, 5)];

            $due->setDueDate($faker->dateTimeBetween('0 years', '1 years'))
                ->setPrincipal(300000)
                ->setInterest(32000)
                ->setPenality(0)
                ->setLoan($loan);

            $manager->persist($due);
        }

        //Ici nous gérons les remboursements
        for ($i = 0; $i < 5; ++$i) {
            $repay = new LoanPayment();
            $loan = $loans[mt_rand(0, 14)];
            $meet = $meetings[mt_rand(0, 5)];

            $repay->setPaidDate($meet->getMeetingAt())
                ->setPrincipal(300000)
                ->setInterest(32000)
                ->setPenality(0)
                ->setLoan($loan);

            $manager->persist($repay);
        }

        //Ici nous gérons les assistances
        for ($i = 0; $i < 5; ++$i) {
            $ass = new Assistance();
            $meet = $meetings[mt_rand(0, 5)];

            $ass->setDistributedDate($meet->getMeetingAt())
                ->setAmount(1000000)
                ->setReason('hôspitalisation')
                ->setBeneficiary($members[mt_rand(0, 19)]);

            $manager->persist($ass);
        }

        //Ici nous gérons les comptes
        $accounts = [];
        $compteCaisse = new Account();

        $compteCaisse->setNumber(101)
        ->setLabel('Caisse interne');

        $manager->persist($compteCaisse);
        $accounts[] = $compteCaisse;

        $compteBank = new Account();
        $compteBank->setNumber(102)
        ->setLabel('Compte Banque');

        $manager->persist($compteBank);
        $accounts[] = $compteBank;

        //Ici nous gérons les mouvements caisses
        for ($i = 0; $i < 50; ++$i) {
            $mvt = new MouvementCaisse();
            $mvtTypes = ['amende', 'assistance', 'caisse sociale', 'crédit', 'remboursement crédit', 'opérations diverses'];

            $mvt->setTransactionDate($faker->dateTimeBetween('0 years', '1 years'))
            ->setAmount(1000000)
            ->setType($mvtTypes[mt_rand(0, 5)])
            ->setAccount($accounts[mt_rand(0, 1)])
            ->setOriginCode(substr($mvtTypes[mt_rand(0, 5)], 0, 6) . mt_rand(1, 500))
            ->setDescription('Un mouvement de caisse normal');

            $manager->persist($mvt);
        }

        $manager->flush();
    }
}
