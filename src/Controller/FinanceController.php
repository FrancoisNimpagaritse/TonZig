<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends AbstractController
{
    // 1.dashbord 2.cotisations 3.caisse sociale 4.octroi crédit 5.remboursement 6.distribution lot 7.sanctions 8.assistance 9.OD
    /**
     * @Route("/finance", name="finance")
     */
    public function index(): Response
    {
        return $this->render('finance/index.html.twig', [
            'controller_name' => 'FinanceController',
        ]);
    }
}
