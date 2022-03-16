<?php

namespace App\Service;

use App\Repository\AppliedSanctionRepository;
use App\Repository\AssistanceRepository;
use App\Repository\LoanDueRepository;
use App\Repository\LoanPaymentRepository;
use App\Repository\LoanRepository;
use App\Repository\MeetingRepository;
use App\Repository\RoundRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

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

        return compact('meetings', 'round', 'loanRepays', 'sanctions', 'assistances', 'currentLoan', 'member');
    }

    public function getCurrentLoanSituation($id) //loan details and due details
    {
        return $this->manager->createQuery("SELECT l FROM App\Entity\loan l JOIN App\Entity\loandue WHERE l.status ='encours' AND l.memid ='".$id."' AND d.dueDate >='".date('now')."'")->getResult();
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


    public function getLoanNextDue($loan)
    {
        $today = (new \DateTime())->format('Y-m-d');
        $qb = $this->manager->createQuery("SELECT d.dueDate, d.principal, d.interest, d.penality
        FROM App\Entity\LoanDue d JOIN App\Entity\Loan l 
         
        WHERE d.loan = :id AND d.dueDate >=  :today");

        return $qb->setParameters(['id'=> $loan, 'today' => $today])->setMaxResults(1)->getResult();
    }

    public function getNextMeeting()
    {
        $today = (new \DateTime())->format('Y-m-d');
        
        //$meetDay = $this->meetingRepo->findBy(["meetingAt" => ">$today"], [], 1, null);
        $qb = $this->manager->createQuery("SELECT m.meetingAt 
        FROM App\Entity\Meeting m 
        WHERE m.meetingAt > :today");
    
        return $qb->setParameter('today', $today)->setMaxResults(1)->getResult();
        //return $meetDay;
    }
}
