<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingController extends AbstractController
{
    /**
     * @Route("/admin/meetings", name="admin_meetings_index")
     */
    public function index(MeetingRepository $meetingRepo): Response
    {
        $meetings = $meetingRepo->findAll(); //only show for open round wth findBy

        return $this->render('meeting/index.html.twig', [
            'meetings' => $meetings,
        ]);
    }

    /**
     * @Route("/admin/meeting/edit/{id}", name="admin_meeting_edit")
     */
    public function edit(Request $request, Meeting $meeting, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($meeting);
            $manager->flush();

            $this->addFlash('success', 'La rencontre N° <strong>'.$meeting->getId().'</strong>, modifiée avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('meeting/edit.html.twig', [
            'form' => $form->createView(),
            'meeting' => $meeting,
        ]);
    }
}
