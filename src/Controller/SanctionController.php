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
    public function create(AppliedSanctionRepository $sanctionRepo, Request $request, EntityManagerInterface $manager): Response
    {
       $sanction = new AppliedSanction;

        $form = $this->createForm(AppliedSanctionType::class, $sanction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                
            $manager->persist($sanction);            

            $manager->flush();

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
    public function edit(AppliedSanction $sanction, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AppliedSanctionType::class, $sanction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

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
    public function delete(AppliedSanction $sanction, EntityManagerInterface $manager): Response
    {
        $manager->remove($sanction);

        $manager->flush();

        $this->addFlash('success', "L'amende desation de <strong> {$sanction->getAmount()} </strong>, a été supprimée avec succès !");

        return $this->redirectToRoute('finances_sanctions_index');
    }
}
