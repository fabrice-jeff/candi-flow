<?php

namespace App\Controller;

use App\Entity\OutilsInformatique;
use App\Entity\Poste;
use App\Repository\OutilsInformatiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutilsInformatiqueController extends AbstractController
{
    private OutilsInformatiqueRepository $outilsInformatiqueRepository;
    private EntityManagerInterface $manager;

    public function __construct(OutilsInformatiqueRepository $outilsInformatiqueRepository, EntityManagerInterface $manager)
    {
        $this->outilsInformatiqueRepository = $outilsInformatiqueRepository;
        $this->manager = $manager;
    }

    #[Route('/outils/informatique', name: 'app_outils_informatique')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('libelle', null, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $outilsInformatique = (new OutilsInformatique())
                ->setLibelle($request->get('form')['libelle']);
            $this->manager->persist($outilsInformatique);
            $this->manager->flush();
            $this->addFlash('success', "Outils informatique enregistré avec succès");
            return  $this->redirectToRoute('app_outils_informatique',);
        }
        return $this->render('outils_informatique/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
