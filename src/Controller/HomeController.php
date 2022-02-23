<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\MeetingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(MeetingRepository $meetingRepo,LoanRepository $loanRepo): Response
    {
        $meetings = $meetingRepo->findAll();
        $memberLoans = $loanRepo->findBy(['member' => $this->getUser()]);
        return $this->render('home/index.html.twig', [
            'meetings'  =>  $meetings,
            'memberloans'   =>  $memberLoans
        ]);
    }
}
