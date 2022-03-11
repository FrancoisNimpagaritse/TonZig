<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use App\Repository\MeetingRepository;
use App\Repository\AssistanceRepository;
use App\Repository\CotisationRepository;
use App\Repository\LoanPaymentRepository;
use App\Repository\CaisseSocialeRepository;
use App\Repository\AppliedSanctionRepository;
use App\Repository\MeetingLotDistributionRepository;

class Stats
{
    private $manager;
    private $meetingRepo;
    private $cotisationRepo;
    private $caissesocioRepo;
    private $loanRepo;
    private $lotdistRepo;
    private $sanctionRepo;
    private $assistanceRepo;
    private $repayRepo;
    private $memRepo;


    public function __construct(EntityManagerInterface $manager, MeetingRepository $meetingRepo,LoanRepository $loanRepo,
    CotisationRepository $cotisationRepo, CaisseSocialeRepository $caissesocioRepo,
    MeetingLotDistributionRepository $lotdistRepo, AppliedSanctionRepository $sanctionRepo, AssistanceRepository $assistanceRepo,
     LoanPaymentRepository $repayRepo, UserRepository $memRepo)
    {
        $this->manager = $manager;
        $this->meetingRepo = $meetingRepo;
        $this->cotisationRepo = $cotisationRepo;
        $this->caissesocioRepo = $caissesocioRepo;
        $this->loanRepo = $loanRepo;
        $this->lotdistRepo = $lotdistRepo;
        $this->sanctionRepo = $sanctionRepo;
        $this->assistanceRepo = $assistanceRepo;
        $this->repayRepo = $repayRepo;
        $this->memRepo = $memRepo;
    }

    public function getReportData()
    {
        $meetings = $this->meetingRepo->findAll();
        $cotisations = $this->cotisationRepo->findAll();
        $caissesociales = $this->caissesocioRepo->findAll();
        $lotdistributions = $this->lotdistRepo->findAll();
        $sanctions = $this->sanctionRepo->findAll();
        $assistances = $this->assistanceRepo->findAll();
        $loans = $this->loanRepo->findAll();
        $repayments = $this->repayRepo->findAll();
        $members = $this->memRepo->findAll();
        $totalLoans = $this->getTotalLoans();
        $totalRepays = $this->getTotalRepays();
        $totalInterestCollected = $this->getTotalInterestCollected();
        $totalAssistances = $this->getTotalAssistances();
        
        return compact('meetings','cotisations', 'caissesociales', 'lotdistributions', 'sanctions', 'assistances', 'loans', 'repayments', 'members', 'totalLoans', 'totalRepays', 'totalInterestCollected', 'totalAssistances');
    }

    public function getTotalLoans(): float
    {
        return $this->manager->createQuery('SELECT SUM(l.amount) FROM App\Entity\Loan l')->getSingleScalarResult();
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