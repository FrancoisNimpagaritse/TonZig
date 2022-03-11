<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/admin/members/edit/{id}", name="admin_members_edit")
     */
    public function edit(User $member, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', "Le membre <strong> {$member->getLastname()} {$member->getFirstname()} </strong> a été modifié avec succès !");

            return $this->redirectToRoute('admin_members_index');
        }

        return $this->render('member/edit.html.twig', [
            'form' => $form->createView(),
            'member' => $member,
        ]);
    }

    /**
     * Permet de supprimer un membre.
     *
     * @Route("/admin/members/delete/{id}", name="admin_members_delete")
     */
    public function delete(User $member, EntityManagerInterface $manager): Response
    {
        $manager->remove($member);

        $manager->flush();

        $this->addFlash('success', 'Le membre <strong>'.$member->getLastname().' '.$member->getFirstname().'</strong>, supprimé avec succès !');

        return $this->redirectToRoute('admin_members_index');
    }
}
