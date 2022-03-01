<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Round;
use App\Form\RoundType;
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
    public function index(): Response
    {
        return $this->render('round/index.html.twig', [
            'controller_name' => 'RoundController',
        ]);
    }

    /**
     * Permet de créer et d'initialiser un cycle
     * 
     * @Route("/admin/rounds/new", name="admin_round_create")
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
}
