<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use App\Repository\MeetingRepository;
use App\Repository\LoanPaymentRepository;
use App\Repository\AppliedSanctionRepository;
use App\Repository\AssistanceRepository;
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
    private $assistanceRepo;


    public function __construct(EntityManagerInterface $manager, RoundRepository $roundRepo, MeetingRepository $meetingRepo,LoanRepository $loanRepo,
    AppliedSanctionRepository $sanctionRepo, LoanPaymentRepository $repayRepo, LoanDueRepository $dueRepo, UserRepository $memRepo, AssistanceRepository $assisRepo)
    {
        $this->manager = $manager;
        $this->meetingRepo = $meetingRepo;
        $this->roundRepo = $roundRepo;
        $this->loanRepo = $loanRepo;
        $this->repayRepo = $repayRepo;
        $this->sanctionRepo = $sanctionRepo;
        $this->dueRepo = $dueRepo;
        $this->memRepo = $memRepo;
        $this->assistanceRepo = $assisRepo;
    }

    public function getReportData($id)
    {
        $meetings = $this->meetingRepo->findAll();
        $round = $this->roundRepo->findOneBy(['status' => 'ouvert']);
        $currentLoan = $this->loanRepo->findOneBy(['memberId' => $id, 'status' => 'encours']);
        $loanRepays = $this->repayRepo->findBy(['memberId' => $id, 'loan.status' => 'encours']);
        $currentLoanDues = $this->dueRepo->findBy(['memberId' => $id, 'status' => 'encours']);
        $member = $this->memRepo->findOneBy(['Id' => $id]);
        $assistances = $this->assistanceRepo->findOneBy(['beneficiaryId' => $id]);
        $sanctions = $this->sanctionRepo->findOneBy(['memberId' => $id]);
        
        return compact('meetings','round', 'loanRepays' ,'sanctions', 'assistances', 'currentLoan', 'member');
    }

    public function getCurrentLoanSituation($id) //loan details and due details
    {
        return $this->manager->createQuery("SELECT l FROM App\Entity\loan l JOIN App\Entity\loandue WHERE l.status ='encours' AND l.memid ='" . $id ."' AND d.dueDate >='" . date("now") . "'")->getResult();
    }

    public function getTotalRepays(): float
    {
        return $this->manager->createQuery('SELECT SUM(r.principal) FROM App\Entity\LoanPayment r')->getSingleScalarResult();
    }

    public function getTotalInterestCollected(): float
    {
        return $this->manager->createQuery('SELECT SUM(r.interest) FROM App\Entity\LoanPayment r')->getSingleScalarResult();
    }

    public function getTotalAssistances(): float
    {
        return $this->manager->createQuery('SELECT SUM(a.amount) FROM App\Entity\Assistance a')->getSingleScalarResult();
    }

}