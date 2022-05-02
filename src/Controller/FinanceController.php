<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use App\Repository\MeetingRepository;
use App\Service\Stats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends AbstractController
{
    // 1.dashbord 2.cotisations 3.caisse sociale 4.octroi crédit 5.remboursement
    //6.distribution lot 7.sanctions 8.assistance 9.OD
    /**
     * @Route("/finances", name="finances_index")
     */
    public function index(Stats $statService, MeetingRepository $meetingRepo, LoanRepository $loanRepo): Response
    {
        $stats = $statService->getReportData();
        $meetings = $meetingRepo->findAll(); //why not use statService?
        $allLoans = $loanRepo->findAll(); //why not use statService?
        $newloan = new Loan();

        $form = $this->createForm(LoanType::class, $newloan, [
            'action' => $this->generateUrl('finances_loans_create'),
            'method' => 'GET',
        ]);

        return $this->render('finance/index.html.twig', [
            'stats' => $stats,
            'meetings' => $meetings,
            'allLoans' => $allLoans,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de créer un crédit.
     *
     * @Route("/finances/loan/new", name="finances_loans_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $loan = new Loan();

        $UserId = $request->query->get('loan')['member'];
        $member = $manager->getReference('App\Entity\User', $UserId);

        $meetingId = $request->query->get('loan')['meeting'];
        $meeting = $manager->getReference('App\Entity\Meeting', $meetingId);
        $dateLoan = new \DateTime($request->request->get('disbursedAt'));

        $loan->setDisbursedAt($dateLoan)
            ->setMeeting($meeting)
            ->setMember($member)
            ->setAmount($request->query->get('loan')['amount'])
            ->setStatus($request->query->get('loan')['status']);

        $manager->persist($loan);

        $manager->flush();

        $this->addFlash('success', 'Crédit <strong>'.$loan->getMember().'</strong>, enregistré avec succès !');

        return $this->redirectToRoute('finance_index');
    }
}
