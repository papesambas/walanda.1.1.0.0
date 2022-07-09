<?php

namespace App\Controller;

use App\Entity\Publications;
use App\Form\EditProfileType;
use App\Form\PublicationsType;
use App\Repository\UsersRepository;
use App\Repository\PublicationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/users')]

class UsersController extends AbstractController
{
    #[Route('/', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    #[Route('/publications', name: 'app_publications_index', methods: ['GET'])]
    public function liste(PublicationsRepository $publicationsRepository): Response
    {
        return $this->render('Users/publications/index.html.twig', [
            'publications' => $publicationsRepository->findAll(),
        ]);
    }

    #[Route('/publications/new', name: 'app_publications_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PublicationsRepository $publicationsRepository): Response
    {
        $publication = new Publications();
        $form = $this->createForm(PublicationsType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publication->setUser($this->getUser());
            $publication->setIsActive(false);
            $publication->setIsFavorit(false);
            $publication->setIsPublished(false);
            $publicationsRepository->add($publication, true);

            return $this->redirectToRoute('app_publications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Users/publications/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publications_show', methods: ['GET'])]
    public function show(Publications $publication): Response
    {
        return $this->render('publications/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UsersRepository $usersRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($user, true);

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/editprofile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/pass/edit', name: 'app_pass_edit', methods: ['GET', 'POST'])]
    public function pass(Request $request, UsersRepository $usersRepos, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        //$em = $this->getDoctrine()->getManager();
        //$user = $this->getUser();

        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            if ($request->request->get('pass') == $request->request->get('pass2')) {
                $user->setPassword($passwordEncoder->hashPassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de pass mis à Jour avec succès');

                return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash('error', 'les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->renderForm('users/editPasse.html.twig');
    }
}
