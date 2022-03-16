<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\MeetingRepository;
use App\Repository\RoundRepository;
use App\Service\MemStats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(MemStats $memstat, RoundRepository $roundRepo, MeetingRepository $meetingRepo, LoanRepository $loanRepo, EntityManagerInterface $manager): Response
    {
        //what is next meeting 
        $currentMemberActiveLoan = $loanRepo->findOneBy(['member' => $this->getUser(), 'status' => 'encours'], ['disbursedAt' => 'DESC']);
        
        $nextDue = $memstat->getLoanNextDue($currentMemberActiveLoan);
        $nextMeeting = $memstat->getNextMeeting(); //can i use this in the home template as next meeting?
        
        //prochaine due date
        $date1 = new \DateTime($nextDue[0]['dueDate']->format('d-m-Y'));
        //prochaine meeting date
        $date2 = new \DateTime($nextMeeting[0]['meetingAt']->format('d-m-Y'));
     /*  echo 'nextDue: ' . $nextDue[0]['dueDate']->format('d-m-Y');
       echo "<br>";
       echo 'next meeting: ' . $nextMeeting[0]['meetingAt']->format('d-m-Y');
        dd(date_diff($date1, $date2)->days); */

        $memberLoanDues = $loanRepo->getMemberLoanDues($this->getUser());
        $memberLoanPymnts = $loanRepo->getMemberLoanPayments($this->getUser());

        $meetings = $meetingRepo->findAll();
        $memberLoans = $loanRepo->findBy(['member' => $this->getUser()]);
       

        $activeRound = $roundRepo->findOneBy(['status' => 'open']);

        return $this->render('home/index.html.twig', [
            'activeRound' => $activeRound,
            'currentMemberActiveLoan' => $currentMemberActiveLoan,
            'meetings' => $meetings,
            'memberLoans' => $memberLoans,
            'memberLoanDues' => $memberLoanDues,
            'memberLoanPymnts' => $memberLoanPymnts,
            'nextDue'    =>  $nextDue[0],
        ]);
    }
}
