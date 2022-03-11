<?php

namespace App\Controller;

use App\Entity\MeetingLotDistribution;
use App\Form\MeetingLotDistributionType;
use App\Repository\MeetingLotDistributionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetingLotDistributionController extends AbstractController
{
    /**
     * Permet d'afficher les lots distribués aux rencontres
     * 
     * @Route("/finances/lot-distributions", name="finances_lot-distributions_index")
     */
    public function index(MeetingLotDistributionRepository $repo): Response
    {
        $lotdistributions = $repo->findAll();
        
        return $this->render('finance/lotdistribution/index.html.twig', [
            'lotdistributions' => $lotdistributions,
        ]);
    }

    /**
     * Permet d'enregistrer un lot distribué à une rencontre
     * 
     * @Route("/finances/lot-distributions/new", name="finances_lot-distributions_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $lotdist = new MeetingLotDistribution();        
        $form = $this->createForm(MeetingLotDistributionType::class, $lotdist);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $lotdist->setBeneficiaires($form->get('beneficiaire1')->getData() . ' et ' . $form->get('beneficiaire2')->getData());
           
            $manager->persist($lotdist);

            $manager->flush();

            $this->addFlash('success', "Le lot a été enregistré avec succès !");

            return $this->redirectToRoute('finances_lot-distributions_index');
        }
        
        return $this->render('finance/lotdistribution/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer l'attribution du lot.
     *
     * @Route("/finances/lot-distributions/delete/{id}", name="finances_lot-distributions_delete")
     */
    public function delete(MeetingLotDistribution $lotdis, EntityManagerInterface $manager): Response
    {
        $manager->remove($lotdis);

        $manager->flush();

        $this->addFlash('success', "Le lot de <strong> {$lotdis->getBeneficiaires()} </strong>, a été supprimé avec succès !");

        return $this->redirectToRoute('finances_lot-distributions_index');
    }
}
