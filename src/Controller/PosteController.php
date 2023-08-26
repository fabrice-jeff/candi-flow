<?php

namespace App\Controller;

use App\Entity\Domaine;
use App\Entity\NiveauEtude;
use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/poste')]
class PosteController extends AbstractController
{
    #[Route('/', name: 'app_poste_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($poste);
            $entityManager->flush();
            $this->addFlash('success', "Poste enregistrée avec succès");
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/liste_poste', name: 'app_poste_liste', methods: ['GET', 'POST'])]
    public function listePoste(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/liste_poste.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }


    #[Route('/add_etudiant/{code}', name: 'app_poste_candidat', methods: ['GET', 'POST'])]
    public function addEtudiant(Poste $poste, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => [
                    'class' => 'form-control default-date-flatpick'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'Femme' => "F",
                    'Homme' => "H"
                ],
                'placeholder' => "Sélectionner un sexe"

            ])
            ->add('domaine', EntityType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Domaine::class,
                'placeholder' => "Sélectionner un domaine"
            ])
            ->add('niveauEtude', EntityType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => NiveauEtude::class,
                'placeholder' => "Sélectionner un niveau d'étude"
            ])
            ->add('contact', TextType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
        ->getForm();
        $form->handleRequest($request);

        return $this->render('poste/add_candidat.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    
}
