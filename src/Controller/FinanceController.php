<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Entity\CaisseSociale;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use App\Repository\MeetingRepository;
use App\Repository\AssistanceRepository;
use App\Repository\CotisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoanPaymentRepository;
use App\Repository\CaisseSocialeRepository;
use App\Repository\AppliedSanctionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MeetingLotDistributionRepository;
use App\Service\Stats;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FinanceController extends AbstractController
{
    // 1.dashbord 2.cotisations 3.caisse sociale 4.octroi crédit 5.remboursement 
    //6.distribution lot 7.sanctions 8.assistance 9.OD
    /**
     * @Route("/finance", name="finance_index")
     */
    public function index(Stats $statService, MeetingRepository $meetingRepo,LoanRepository $loanRepo,
        CotisationRepository $cotisationRepo, CaisseSocialeRepository $caissesocioRepo,
        MeetingLotDistributionRepository $lotdistRepo, AppliedSanctionRepository $sanctionRepo, AssistanceRepository $assistanceRepo,
         LoanPaymentRepository $repayRepo, UserRepository $memRepo, MeetingRepository $meetRepo): Response
    {
        $stats = $statService->getReportData();
        $meetings = $meetingRepo->findAll();
        
        $newloan = new Loan();
        $form = $this->createForm(LoanType::class, $newloan, [
            'action' => $this->generateUrl('finance_loan_create'),
            'method' => 'GET',
        ]);

        return $this->render('finance/index.html.twig', [
            'stats' =>  $stats,
            'meetings'  =>  $meetings,
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * Permet de créer un crédit
     * 
     * @Route("/finance/loan/new", name="finance_loan_create")
     * 
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $loan = new Loan();

        $UserId = $request->query->get('loan')['member'];
        $member = $manager->getReference('App\Entity\User', $UserId);
        
        $meetingId = $request->query->get('loan')['meeting'];
        $meeting = $manager->getReference('App\Entity\Meeting', $meetingId);
        $dateLoan =  new \DateTime($request->request->get('disbursedAt'));
       //dd($request);
        $loan->setDisbursedAt($dateLoan)
            ->setMeeting($meeting)
            ->setMember($member)
            ->setAmount($request->query->get('loan')['amount'])
            ->setStatus($request->query->get('loan')['status']);
        //dd($loan);
        $manager->persist($loan);

        $manager->flush();

        $this->addFlash('success', 'Crédit <strong>' . $loan->getMember() . '</strong>, enregistré avec succès !');

        return $this->redirectToRoute('finance_index');
       /*

        dd('here');
        return $this->render('loan/index.html.twig', [
            'form' => $form->createView(),
        ]);  */
    }
}
