<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Entity\LoanPayment;
use App\Form\LoanPaymentType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoanPaymentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoanPaymentController extends AbstractController
{
    /**
     * Permet de lister les remboursement des crédits
     * 
     * @Route("/finances/loanpayments", name="finances_loanpayments_index")
     */
    public function index(LoanPaymentRepository $repo): Response
    {
        $loanpayments = $repo->findAll();

        return $this->render('finance/loanpayment/index.html.twig', [
            'loanpayments' => $loanpayments,
        ]);
    }

    /**
     * Permet de saisir un remboursement de crédit en cherchant dans la liste
     * 
     * @Route("/finances/loanpayments/new", name="finances_loanpayments_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $loanpay = new LoanPayment();
        $form = $this->createForm(LoanPaymentType::class, $loanpay);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($loanpay);
            $manager->flush();

            $this->addFlash('success', "Le remboursement de {$loanpay->getPrincipal()} pour {$loanpay->getLoan()->getMember()} a été enregistré avec succès !");

            return $this->redirectToRoute('finances_loanpayments_index');
        }

        return $this->render('finance/loanpayment/new.html.twig', [
            'form'  =>  $form->createView()
        ]);
    }

    /**
     * Permet de payer un remboursement de crédit basé sur un numéro de crédit
     * 
     * @Route("/finances/loanpayments/pay/{id}", name="finances_loanpayments_pay")
     */
    public function pay(Loan $loan, Request $request, EntityManagerInterface $manager): Response
    {
        $loanpay = new LoanPayment();
        $loanpay->setLoan($loan);
        
        $form = $this->createForm(LoanPaymentType::class, $loanpay);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($loanpay);
            $manager->flush();

            $this->addFlash('success', "Le remboursement de {$loanpay->getPrincipal()} pour {$loanpay->getLoan()->getmember()} a été modifié avec succès !");

            return $this->redirectToRoute('finances_loanpayments_index');
        }
        return $this->render('finance/loanpayment/edit.html.twig', [
            'form'  =>  $form->createView(),
        ]);
    }
     
    /**
     * Permet de modifier un remboursement de crédit
     * 
     * @Route("/finances/loanpayments/edit/{id}", name="finances_loanpayments_edit")
     */
    public function edit(LoanPayment $loanpay, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(LoanPaymentType::class, $loanpay);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($loanpay);
            $manager->flush();

            $this->addFlash('success', "Le remboursement de {$loanpay->getPrincipal()} pour {$loanpay->getLoan()->getmember()} a été modifié avec succès !");

            return $this->redirectToRoute('finances_loanpayments_index');
        }
        return $this->render('finance/loanpayment/edit.html.twig', [
            'form'  =>  $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer un remboursement de crédit
     * 
     * @Route("/finances/loanpayments/delete/{id}", name="finances_loanpayments_delete")
     */
    public function delete(LoanPayment $loanpay, EntityManagerInterface $manager): Response
    {
        $manager->remove($loanpay);
        $manager->flush();

        $this->addFlash('success', "Le remboursement de {$loanpay->getPrincipal()} pour {$loanpay->getLoan()->getmember()} a été supprimé avec succès !");

        return $this->redirectToRoute('finances_loanpayments_index');
    }
}
