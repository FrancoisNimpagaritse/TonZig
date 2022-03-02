<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Round;
use App\Form\RoundType;
use App\Repository\RoundRepository;
use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoundController extends AbstractController
{
    /**
     * @Route("/admin/rounds", name="admin_rounds_index")
     */
    public function index(RoundRepository $roundRepo): Response
    {
        $rounds = $roundRepo->findAll();

        return $this->render('round/index.html.twig', [
            'rounds' => $rounds,
        ]);
    }

    /**
     * Permet de créer et d'initialiser un cycle
     * 
     * @Route("/admin/rounds/new", name="admin_rounds_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $round = new Round();
        
        $form = $this->createForm(RoundType::class, $round);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //Créer aussi les meeting en se servant des valeurs saisies sur formulaire
            
            $startDate = $form->get('roundStartDate')->getData();            
            $ecart = $form->get('meetingFrequency')->getData();
            $effectif = $form->get('totalMeetings')->getData();

            $text = $startDate->format('Y-m-d');
            
            for($i = 0; $i < $effectif; $i++){
                $meeting = new Meeting();

                $meetingDate = date("Y-m-d", strtotime($text.'+ ' . ($i * $ecart) . ' days'));

                $meeting->setMeetingAt(new DateTime($meetingDate))
                        ->setStatus("future")
                        ->setRemainingMeetings($effectif - $i - 1)
                        ->setRound($round);

                $manager->persist($meeting);
            }
            
            $manager->persist($round);
            $manager->flush();

            $this->addFlash('success', 'Round N° <strong>' . $round->getRoundNumber() . '</strong>, créé avec succès !');

            return $this->redirectToRoute('app_home');
        }


        return $this->render('round/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de modifier un cycle
     * 
     * @Route("/admin/rounds/edit/{id}", name="admin_rounds_edit")
     */
    public function edit(Request $request, Round $round, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(RoundType::class, $round);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($round); //not sure if we need to persist it
            $manager->flush();

            $this->addFlash('success', 'Round N° <strong>' . $round->getRoundNumber() . '</strong>, modifié avec succès !');

            return $this->redirectToRoute('app_home');
        }


        return $this->render('round/edit.html.twig', [
            'form' => $form->createView(),
            'round' =>  $round,
        ]);
    }

    /**
     * Permet de supprimer un cycle
     * 
     * @Route("/admin/rounds/delete/{id}", name="admin_rounds_delete")
     */
    public function delete(Round $round, EntityManagerInterface $manager): Response
    {
        $manager->remove($round);
            
        $manager->flush();

        $this->addFlash('success', 'Round N° <strong>' . $round->getRoundNumber() . '</strong>, supprimé avec succès !');

        return $this->redirectToRoute('admin_rounds_index');
       
    }
}
