<?php

namespace App\Controller;

use App\Entity\Tontine;
use App\Form\TontineType;
use App\Repository\TontineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TontineController extends AbstractController
{
    /**
     * @Route("/tontine", name="tontine")
     */
    public function index(): Response
    {
        return $this->render('tontine/index.html.twig', [
            'controller_name' => 'TontineController',
        ]);
    }

    /**
     * @Route("/admin/tontine/new", name="admin_tontine_create")
     */
    public function create(Request $request, EntityManagerInterface $manager, TontineRepository $repo): Response
    {
        $nbrTontines = $repo->findAll();

        if (count($nbrTontines) > 1) {
            return new Response("Vous ne pouvez pas créer plus d'une tontine !");
        }

        $tontine = new Tontine();

        $form = $this->createForm(TontineType::class, $tontine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tontine);
            $manager->flush();

            $this->addFlash('success', 'Tontine <strong>'.$tontine->getName().'</strong>, créée avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('tontine/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * "Permet d'éditer les détails d'une tontine.
     *
     * @Route("/admin/tontine/edit/{id}", name="admin_tontine_edit")
     */
    public function edit(Tontine $tontine, Request $request, EntityManagerInterface $manager, TontineRepository $repo): Response
    {
        $form = $this->createForm(TontineType::class, $tontine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tontine);
            $manager->flush();

            $this->addFlash('success', 'Tontine <strong>'.$tontine->getName().'</strong>, modifiée avec succès !');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('tontine/edit.html.twig', [
            'form' => $form->createView(),
            'tontine' => $tontine,
        ]);
    }
}
