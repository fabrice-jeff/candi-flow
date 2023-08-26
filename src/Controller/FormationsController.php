<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Poste;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    #[Route('/formations/{code}', name: 'app_formations')]
    public function index(Request $request, Poste $poste, FormationRepository $formationRepository, EntityManagerInterface $manager): Response
    {
        $formations = $formationRepository->findBy(['poste' => $poste, "deleted" =>false]);
        $form = $this->createFormBuilder()
            ->add('libelle',TextType::class,
            [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $formation =  (new Formation())
            ->setLibelle($request->get('form')['libelle'])
            ->setPoste($poste);
            $manager->persist($formation);
            $this->addFlash('success', "Formation enregistré avec succès");
            $manager->flush();
            return $this->redirectToRoute('app_formations',[
                'code' => $poste->getCode()
            ]);
        }
        return $this->render('formations/index.html.twig', [
            'poste' => $poste,
            'form' =>$form->createView(),
            'formations' => $formations
        ]);
    }
}
