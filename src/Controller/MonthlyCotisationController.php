<?php

namespace App\Controller;

use App\Entity\Cotisation;
use App\Form\CotisationAmountType;
use App\Repository\CotisationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonthlyCotisationController extends AbstractController
{
    /**
     * @Route("/finances/cotisations", name="finances_cotisations_index")
     */
    public function index(CotisationRepository $cotisRepo): Response
    {
        $cotisations = $cotisRepo->findAll();

        return $this->render('finance/cotisation/index.html.twig', [
            'cotisations' => $cotisations,
        ]);
    }

    /**
     * Permet d'enregistrer la cotisation mensuelle pour tous les membres du round.
     *
     * @Route("/finances/cotisations/new", name="finances_cotisations_create")
     */
    public function create(UserRepository $memberRepo, Request $request, EntityManagerInterface $manager): Response
    {
        //1. Find all active members
        $activeMembers = $memberRepo->findBy(['status' => 'actif']);

        $form = $this->createForm(CotisationAmountType::class); //just the amount
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //2. Find current round's cotistion amount from a created form for that purpose only
            $meeting = $form->get('meeting')->getData();
            $amount = $form->get('meeting')->getData()->getRound()->getMonthlyCotisation();
            $note = $form->get('note')->getData();

            for ($i = 0; $i < count($activeMembers); ++$i) {
                //3. Create a new cotisation for each active member
                $member = $activeMembers[$i];

                $cotis = new Cotisation();
                //4. Set values
                $cotis->setMeeting($meeting)
                    ->setMember($member)
                    ->setAmount($amount)
                    ->setNote($note);

                //5. Persist each cotisation
                $manager->persist($cotis);
            }

            $manager->flush();

            $this->addFlash('success', "Les cotisations de tous les membres pour la rencontre du {$cotis->getMeeting()->getMeetingAt()->format('d/m/Y')} </strong> ont été enregistrées avec succès !");

            return $this->redirectToRoute('finances_index');
        }

        return $this->render('finance/cotisation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer les cotisations d'une date donnée.
     *
     * @Route("/finances/cotisations/delete/{id}", name="finances_cotisations_delete")
     */
    public function delete(Cotisation $cotis, EntityManagerInterface $manager): Response
    {
        $manager->remove($cotis);

        $manager->flush();

        $this->addFlash('success', 'La cotisation de <strong>'.$cotis->getmember()->getLastname().' '.$cotis->getMember()->getFirstname().'</strong>, a été supprimée avec succès !');

        return $this->redirectToRoute('finances_cotisations_index');
    }
}
