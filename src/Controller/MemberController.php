<?php

namespace App\Controller;

use App\Repository\MeetingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/admin/members", name="admin_members_index")
     */
    public function index(UserRepository $userRepo): Response
    {
        $members = $userRepo->findAll();

        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }
}
