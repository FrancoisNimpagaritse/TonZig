<?php

namespace App\Controller;

use App\Entity\MouvementCaisse;
use App\Form\MouvementCaisseType;
use App\Repository\MouvementCaisseRepository;
use App\Service\Stats;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MouvementCaisseController extends AbstractController
{
    /**
     * Permet d'afficher les mouvements de la caisse du cycle
     * 
     * @Route("finances/mouvementcaisses", name="finances_mouvementcaisses_index")
     */
    public function index(Stats $stat,MouvementCaisseRepository $mvtRepo): Response
    {
        $mouvements = $mvtRepo->findAll();
        $soldeCaisse = $stat->getSoldeCaisse();
        
        return $this->render('finance/mouvementcaisse/index.html.twig', [
            'mouvements' =>  $mouvements,
            'soldeCaisse' => $soldeCaisse
        ]);
    }

    /**
     * Permet de créer un mouvement de caisse manuel
     * 
     * @Route("finances/mouvementcaisses/new", name="finances_mouvementcaisses_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $mouvement = new MouvementCaisse();

        $form = $this->createForm(MouvementCaisseType::class, $mouvement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //tenir compte du typee (in or out) pour le signe de amount
            $typeMvnt = $form->get('type')->getData();

            if($typeMvnt == 'sortie'){
                $mouvement->setAmount((-1) * $form->get('amount')->getData());
            }
            //dd($mouvement);
            $manager->persist($mouvement);
            $manager->flush();

            $this->addFlash('success', "L'opération a été enregistrée avec succès !");

            return $this->redirectToRoute('finances_mouvementcaisses_index');
        }
        
        return $this->render('finance/mouvementcaisse/new.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }

    /**
     * Permet d'éditer un mouvement de caisse manuellement
     * 
     * @Route("finances/mouvementcaisses/edit/{id}", name="finances_mouvementcaisses_edit")
     */
    public function edit(Request $request, MouvementCaisse $mouvement, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(MouvementCaisseType::class, $mouvement);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //tenir compte du typee (in or out) pour le signe de amount
            $typeMvnt = $form->get('type')->getData();
            
            if($typeMvnt == 'sortie'){
                $mouvement->setAmount((-1) * $form->get('amount')->getData());
            }            
            $manager->persist($mouvement);
            $manager->flush();

            $this->addFlash('success', "L'opération a été enregistrée avec succès !");

            return $this->redirectToRoute('finances_mouvementcaisses_index');
        }
        
        return $this->render('finance/mouvementcaisse/edit.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }

    /**
     * Permet d'éditer un mouvement de caisse manuellement
     * 
     * @Route("finances/mouvementcaisses/delete/{id}", name="finances_mouvementcaisses_delete")
     */
    public function delete(MouvementCaisse $mouvement, EntityManagerInterface $manager): Response
    {
        $manager->remove($mouvement);
        $manager->flush();

        $this->addFlash('success', "L'opération a été supprimée avec succès !");

        return $this->redirectToRoute('finances_mouvementcaisses_index');
    }
}
