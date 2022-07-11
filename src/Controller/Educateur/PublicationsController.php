<?php

namespace App\Controller\Educateur;

use App\Entity\Publications;
use App\Form\PublicationsType;
use App\Repository\PublicationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/educateur/publications')]
class PublicationsController extends AbstractController
{
    #[Route('/', name: 'app_educateur_publications_index', methods: ['GET'])]
    public function index(PublicationsRepository $publicationsRepository): Response
    {
        return $this->render('educateur/publications/index.html.twig', [
            'publications' => $publicationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_educateur_publications_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PublicationsRepository $publicationsRepository): Response
    {
        $publication = new Publications();
        $form = $this->createForm(PublicationsType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationsRepository->add($publication, true);

            return $this->redirectToRoute('app_educateur_publications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('educateur/publications/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_educateur_publications_show', methods: ['GET'])]
    public function show(Publications $publication): Response
    {
        return $this->render('educateur/publications/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_educateur_publications_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publications $publication, PublicationsRepository $publicationsRepository): Response
    {
        $form = $this->createForm(PublicationsType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationsRepository->add($publication, true);

            return $this->redirectToRoute('app_educateur_publications_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('educateur/publications/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_educateur_publications_delete', methods: ['POST'])]
    public function delete(Request $request, Publications $publication, PublicationsRepository $publicationsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $publication->getId(), $request->request->get('_token'))) {
            $publicationsRepository->remove($publication, true);
        }

        return $this->redirectToRoute('app_educateur_publications_index', [], Response::HTTP_SEE_OTHER);
    }
}
