<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/admin/members/edit/{id}", name="admin_members_edit")
     */
    public function edit(User $member, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('succes', 'Le membre <strong>' . $member->getLastname() . $member->getFirstname() . '</strong> a été modifié avec succès !');

            return $this->redirectToRoute('admin_members_index');

        }

        return $this->render('member/edit.html.twig', [
            'form' =>   $form->createView(),
            'member' => $member,
        ]);
    }
}
