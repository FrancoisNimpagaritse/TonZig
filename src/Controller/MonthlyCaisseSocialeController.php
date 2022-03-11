<?php

namespace App\Controller;

use App\Entity\CaisseSociale;
use App\Form\CaisseSocialeAmountType;
use App\Repository\CaisseSocialeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonthlyCaisseSocialeController extends AbstractController
{
    /**
     * @Route("/finances/caissesociales", name="finances_caissesociales_index")
     */
    public function index(CaisseSocialeRepository $caisseRepo): Response
    {
        $caissesociales = $caisseRepo->findAll();

        return $this->render('finance/caissesociale/index.html.twig', [
            'caissesociales' => $caissesociales,
        ]);
    }

    /**
     * Permet de d'nregistrer la caisse sociale pour tous les membres actifs du round.
     *
     * @Route("/finances/caissesociales/new", name="finances_caissesociales_create")
     */
    public function create(UserRepository $memberRepo, Request $request, EntityManagerInterface $manager): Response
    {
        //1. Find all active members
        $activeMembers = $memberRepo->findBy(['status' => 'actif']);

        $form = $this->createForm(CaisseSocialeAmountType::class); //just the amount
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //2. Find current round's cotistion amount from a created form for that purpose only
            $meeting = $form->get('meeting')->getData();
            $amount = $form->get('meeting')->getData()->getRound()->getMonthlyCotisation();
            $note = $form->get('note')->getData();

            for ($i = 0; $i < count($activeMembers); ++$i) {
                //3. Create a new cotisation for each active member
                $member = $activeMembers[$i];

                $caissesoc = new CaisseSociale();
                //4. Set values
                $caissesoc->setMeeting($meeting)
                    ->setMember($member)
                    ->setAmount($amount)
                    ->setNote($note);

                //5. Persist each cotisation
                $manager->persist($caissesoc);
            }

            $manager->flush();

            $this->addFlash('success', "La caisse sociale de tous les membres pour la rencontre du {$caissesoc->getMeeting()->getMeetingAt()->format('d/m/Y')} </strong> a été enregistrée avec succès !");

            return $this->redirectToRoute('finances_index');
        }

        return $this->render('finance/caissesociale/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer la caisse sociale d'une date donnée.
     *
     * @Route("/finances/caissesociales/delete/{id}", name="finances_caissesociales_delete")
     */
    public function delete(CaisseSociale $caisse, EntityManagerInterface $manager): Response
    {
        $manager->remove($caisse);

        $manager->flush();

        $this->addFlash('success', 'La cotisation de <strong>'.$caisse->getmember()->getLastname().' '.$caisse->getMember()->getFirstname().'</strong>, a été supprimée avec succès !');

        return $this->redirectToRoute('finances_cotisations_index');
    }
}
