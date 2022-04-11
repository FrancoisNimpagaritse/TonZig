<?php

namespace App\Controller;

use App\Entity\AppliedSanction;
use App\Form\AppliedSanctionType;
use PharIo\Manifest\ApplicationName;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppliedSanctionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Event\Sanction\AppliedSanctionEditedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SanctionController extends AbstractController
{
    /**
     * @Route("/finances/sanctions", name="finances_sanctions_index")
     */
    public function index(AppliedSanctionRepository $repo): Response
    {
        $sanctions = $repo->findAll();
        
        return $this->render('finance/sanction/index.html.twig', [
            'sanctions' => $sanctions,
        ]);
    }

    /**
     * Permet d'enregistrer une amende infligée à un membre.
     *
     * @Route("/finances/sanctions/new", name="finances_sanctions_create")
     */
    public function create(Request $request, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
       $sanction = new AppliedSanction;

        $form = $this->createForm(AppliedSanctionType::class, $sanction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($sanction);

            $manager->flush();
            //Evénement créé
			$sanctionAddedEvent = (new AppliedSanctionEditedEvent($sanction));
            //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
            $eventDispatcher->dispatch($sanctionAddedEvent, 'appliedSanction.added');

            $this->addFlash('success', "L'amende de {$sanction->getAmount()} pour {$sanction->getSanctionType()} de {$sanction->getMember()->getFirstname()} {$sanction->getMember()->getLastname()} </strong> a été enregistrée avec succès !");

            return $this->redirectToRoute('finances_sanctions_index');
        }

        return $this->render('finance/sanction/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/finances/sanctions/edit/{id}", name="finances_sanctions_edit")
     */
    public function edit(AppliedSanction $sanction, Request $request, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AppliedSanctionType::class, $sanction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            //Evénement créé
			$sanctionAddedEvent = (new AppliedSanctionEditedEvent($sanction));
            //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
            $eventDispatcher->dispatch($sanctionAddedEvent, 'appliedSanction.edited');

            $this->addFlash('success', "L'amende de <strong> {$sanction->getAmount()} pour {$sanction->getMember()->getFirstname()} {$sanction->getMember()->getLastname()} </strong>, a été modifiée avec succès !");

            return $this->redirectToRoute('finances_sanctions_index');
        }

        return $this->render('finance/sanction/edit.html.twig', [
            'form' => $form->createView(),
            'sanction' => $sanction,
        ]);
    }

    /**
     * Permet de supprimer la'amende d'un membre.
     *
     * @Route("/finances/sanctions/delete/{id}", name="finances_sanctions_delete")
     */
    public function delete(AppliedSanction $sanction, EventDispatcherInterface $eventDispatcher, EntityManagerInterface $manager): Response
    {
        $manager->remove($sanction);

        //Evénement créé
        $sanctionAddedEvent = (new AppliedSanctionEditedEvent($sanction));
        //Dispatcher ou propager l'événement tout en définissant son nom utilisé dans la propagation de cet événement
        $eventDispatcher->dispatch($sanctionAddedEvent, 'appliedSanction.deleted');

        $manager->flush();

        $this->addFlash('success', "L'amende desation de <strong> {$sanction->getAmount()} </strong>, a été supprimée avec succès !");

        return $this->redirectToRoute('finances_sanctions_index');
    }
}
