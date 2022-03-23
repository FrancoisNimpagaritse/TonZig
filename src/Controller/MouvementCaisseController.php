<?php

namespace App\Controller;

use App\Repository\MouvementCaisseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MouvementCaisseController extends AbstractController
{
    /**
     * @Route("finances/mouvementcaisses", name="finances_mouvementcaisses_index")
     */
    public function index(MouvementCaisseRepository $mvtRepo): Response
    {
        $mouvements = $mvtRepo->findAll();

        return $this->render('finance/mouvementcaisse/index.html.twig', [
            'mouvements' =>  $mouvements,
        ]);
    }
}
