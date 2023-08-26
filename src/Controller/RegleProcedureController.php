<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Entity\RegleProcedure;
use App\Repository\RegleProcedureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegleProcedureController extends AbstractController
{
    #[Route('/regle/procedure/{code}', name: 'app_regle_procedure')]
    public function index(Request $request,Poste $poste, RegleProcedureRepository $regleProcedureRepository, EntityManagerInterface $manager): Response
    {
        $reglesProcedures = $regleProcedureRepository->findBy(['poste' => $poste, "deleted" => false]);
        $form = $this->createFormBuilder()
            ->add('libelle',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $regleProcedure = (new RegleProcedure())
                ->setPoste($poste)
                ->setLibelle($request->get('form')['libelle']);
            $manager->persist($regleProcedure);
            $this->addFlash('success', "Règles et procédures enregistré avec succès");
            $manager->flush();
            return $this->redirectToRoute('app_regle_procedure',[
                'code' => $poste->getCode()
            ]);
        }
        return $this->render('regle_procedure/index.html.twig', [
            'poste' => $poste,
            'form' => $form->createView(),
            'regles_procedures' => $reglesProcedures
        ]);
    }
}
