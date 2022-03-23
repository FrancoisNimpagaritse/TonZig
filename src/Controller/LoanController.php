<?php

namespace App\Controller;

use DateTime;
use App\Entity\Loan;
use App\Form\LoanType;
use App\Service\Stats;
use App\Entity\LoanDue;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoanController extends AbstractController
{
    /**
     * Permet d'afficher la liste des crédits octroyés
     * 
     * @Route("/finances/loans", name="finances_loans_index")
     */
    public function index(LoanRepository $loanRepo): Response
    {
        $allLoans = $loanRepo->getAllLoansBalance();
        
        return $this->render('finance/loan/index.html.twig', [
            'allLoans' => $allLoans,
        ]);
    }

    /**
     * Permet d'afficher la liste des crédits octroyés
     * 
     * @Route("/finances/loans/new", name="finances_loans_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);        

        if($form->isSubmitted() && $form->isValid()){
            //loan params
            $loanAmount = $form->get('amount')->getData();
            $numberOfInstallments = $form->get('duration')->getData();
            $interestRate = 1; 
            $loanDisbursementDate = $form->get('disbursedAt')->getData();
            $text = $loanDisbursementDate->format('Y-m-d');
            //generate dues
            for($i = 1; $i <= $numberOfInstallments; $i++){
                $installment = new LoanDue();
                $installmentDate = date('Y-m-d', strtotime($text.'+ '.($i * 30).' days'));

                $installment->setDueDate(new DateTime($installmentDate))//date_add($loanDisbursementDate, date_interval_create_from_date_string($i * 30 . 'days')))
                        ->setPrincipal($loanAmount / $numberOfInstallments)
                        ->setInterest(($loanAmount * $interestRate) / (100 * $numberOfInstallments))
                        ->setPenality(0)
                        ->setLoan($loan);

                //dd($installment);
                $manager->persist($installment);
            }

            $manager->persist($loan);
            $manager->flush();

            $this->addFlash('success', "Le crédit de {$loan->getMember()} pour un montant de {$loan->getAmount()} a été enregistré avec succès !");

            return $this->redirectToRoute('finances_loans_index');
        }

        return $this->render('finance/loan/new.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }
}
