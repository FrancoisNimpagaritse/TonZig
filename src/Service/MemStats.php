<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use App\Repository\MeetingRepository;
use App\Repository\LoanPaymentRepository;
use App\Repository\AppliedSanctionRepository;
use App\Repository\LoanDueRepository;
use App\Repository\RoundRepository;

class MemStats
{
    private $manager;
    private $meetingRepo;
    private $roundRepo;
    private $loanRepo;
    private $sanctionRepo;
    private $repayRepo;
    private $memRepo;
    private $dueRepo;


    public function __construct(EntityManagerInterface $manager, RoundRepository $roundRepo, MeetingRepository $meetingRepo,LoanRepository $loanRepo,
    AppliedSanctionRepository $sanctionRepo, LoanPaymentRepository $repayRepo, LoanDueRepository $dueRepo, UserRepository $memRepo)
    {
        $this->manager = $manager;
        $this->meetingRepo = $meetingRepo;
        $this->roundRepo = $roundRepo;
        $this->loanRepo = $loanRepo;
        $this->sanctionRepo = $sanctionRepo;
        $this->dueRepo = $dueRepo;
        $this->memRepo = $memRepo;
    }

    public function getReportData($id)
    {
        $meetings = $this->meetingRepo->findAll();
        $round = $this->roundRepo->findOneBy(['status' => 'ouvert']);
        $currentLoan = $this->loanRepo->findOneBy(['memberId' => $id, 'status' => 'encours']);
        $currentLoanDues = $this->dueRepo->findBy(['memberId' => $id, 'status' => 'encours']);
        $member = $this->memRepo->findOneBy(['Id' => $id]);
        
        return compact('meetings','round', 'sanctions', 'assistances', 'currentLoan', 'nextCurrentLoanDue', 'member');
    }

    public function getCurrentLoanSituation() //loan details and due details
    {
        return $this->manager->createQuery("SELECT l FROM App\Entity\loan l JOIN App\Entity\loandue WHERE l.status ='encours' AND l.memid ='" . $currentLoan ."' AND d.dueDate >='" . date("now") . "'")->getResult();
    }

    public function getTotalRepays()
    {
        return $this->manager->createQuery('SELECT SUM(r.principal) FROM App\Entity\LoanPayment r')->getSingleScalarResult();
    }

    public function getTotalInterestCollected()
    {
        return $this->manager->createQuery('SELECT SUM(r.interest) FROM App\Entity\LoanPayment r')->getSingleScalarResult();
    }

    public function getTotalAssistances()
    {
        return $this->manager->createQuery('SELECT SUM(a.amount) FROM App\Entity\Assistance a')->getSingleScalarResult();
    }

}