<?php

namespace App\Controller;

use App\Entity\NiveauEtude;
use App\Form\NiveauEtudeType;
use App\Repository\NiveauEtudeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/niveau/etude')]
class NiveauEtudeController extends AbstractController
{
    #[Route('/', name: 'app_niveau_etude_index', methods: ['GET'])]
    public function index(NiveauEtudeRepository $niveauEtudeRepository): Response
    {
        return $this->render('niveau_etude/index.html.twig', [
            'niveau_etudes' => $niveauEtudeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_niveau_etude_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $niveauEtude = new NiveauEtude();
        $form = $this->createForm(NiveauEtudeType::class, $niveauEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($niveauEtude);
            $this->addFlash('success', "Niveau d'étude enregistré avec succès");
            $entityManager->flush();

            return $this->redirectToRoute('app_niveau_etude_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau_etude/new.html.twig', [
            'niveau_etude' => $niveauEtude,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveau_etude_show', methods: ['GET'])]
    public function show(NiveauEtude $niveauEtude): Response
    {
        return $this->render('niveau_etude/show.html.twig', [
            'niveau_etude' => $niveauEtude,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_niveau_etude_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NiveauEtude $niveauEtude, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NiveauEtudeType::class, $niveauEtude);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_niveau_etude_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('niveau_etude/edit.html.twig', [
            'niveau_etude' => $niveauEtude,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_niveau_etude_delete', methods: ['POST'])]
    public function delete(Request $request, NiveauEtude $niveauEtude, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niveauEtude->getId(), $request->request->get('_token'))) {
            $entityManager->remove($niveauEtude);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_niveau_etude_index', [], Response::HTTP_SEE_OTHER);
    }
}
