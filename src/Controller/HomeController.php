<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\MeetingRepository;
use App\Repository\RoundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(RoundRepository $roundRepo, MeetingRepository $meetingRepo, LoanRepository $loanRepo): Response
    {
        $memberLoanDues = $loanRepo->getMemberLoanDues($this->getUser());
        $memberLoanPymnts = $loanRepo->getMemberLoanPayments($this->getUser());

        $meetings = $meetingRepo->findAll();
        $memberLoans = $loanRepo->findBy(['member' => $this->getUser()]);
        //prochaine due -> DQL ou QueryBuilder
        $memberActiveLoan = $loanRepo->findOneBy(['member' => $this->getUser(), 'status' => 'encours'], ['disbursedAt' => 'DESC']);

        $activeRound = $roundRepo->findOneBy(['status' => 'open']);

        return $this->render('home/index.html.twig', [
            'activeRound' => $activeRound,
            'memberActiveLoan' => $memberActiveLoan,
            'meetings' => $meetings,
            'memberLoans' => $memberLoans,
            'memberLoanDues' => $memberLoanDues,
            'memberLoanPymnts' => $memberLoanPymnts,
        ]);
    }
}
