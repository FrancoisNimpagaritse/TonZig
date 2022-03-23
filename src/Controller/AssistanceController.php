<?php

namespace App\Controller;

use App\Entity\Assistance;
use App\Event\Assistance\AssistanceEditedEvent;
use App\Form\AssistanceType;
use App\Repository\AssistanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssistanceController extends AbstractController
{
    /**
     * Permet d'afficher la liste des assistances accordées durant le round
     * 
     * @Route("/finances/assistances", name="finances_assistances_index")
     */
    public function index(AssistanceRepository $repo): Response
    {
        $assistances = $repo->findAll();

        return $this->render('finance/assistance/index.html.twig', [
            'assistances' => $assistances,
        ]);
    }

    /**
     * Permet d'ajouter une assistance accordée à un membre durant le round
     * 
     * @Route("/finances/assistances/new", name="finances_assistances_create")
     */
    public function create(Request $request, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
        $assist = new Assistance();
        $form = $this->createForm(AssistanceType::class, $assist);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($assist);
            $manager->flush();
            
            //Evénement créé
			$assistAddedEvent = (new AssistanceEditedEvent($assist));
            //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
            $eventDispatcher->dispatch($assistAddedEvent, 'assistance.added');
            
            $this->addFlash('success', "L'assistance de {$assist->getAmount()} accordée à {$assist->getBeneficiary()} a été enregistrée avec succès !");
            
            return $this->redirectToRoute('finances_assistances_index');
        }


        return $this->render('finance/assistance/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'éditer une assistance accordée à un membre durant le round
     * 
     * @Route("/finances/assistances/edit/{id}", name="finances_assistances_edit")
     */
    public function edit(Assistance $assist, Request $request, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AssistanceType::class, $assist);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            
            //Evénement créé
			$assistAddedEvent = (new AssistanceEditedEvent($assist));
            //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
            $eventDispatcher->dispatch($assistAddedEvent, 'assistance.edited');
            

            $this->addFlash('success', "L'assistance de {$assist->getAmount()} accordée à {$assist->getBeneficiary()} a été modifiée avec succès !");

            return $this->redirectToRoute('finances_assistances_index');
        }

        return $this->render('finance/assistance/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer une assistance accordée à un membre durant le round
     * 
     * @Route("/finances/assistances/delete/{id}", name="finances_assistances_delete")
     */
    public function delete(Assistance $assist, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
        $manager->remove($assist);
        //Evénement créé
        $assistAddedEvent = (new AssistanceEditedEvent($assist));
        //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
        $eventDispatcher->dispatch($assistAddedEvent, 'assistance.deleted');

        $manager->flush();

        

        $this->addFlash('danger', "L'assistance de {$assist->getAmount()} qui était accordée à {$assist->getBeneficiary()} a été supprimée !");

        return $this->redirectToRoute('finances_assistances_index');
    }
}
