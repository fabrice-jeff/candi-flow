<?php

namespace App\Controller;

use App\Entity\CritereAtouts;
use App\Entity\CritereDiplome;
use App\Entity\CritereExigence;
use App\Entity\CritereExperience;
use App\Entity\MatriceEvaluation;
use App\Entity\Poste;
use App\Repository\AutreInformationRepository;
use App\Repository\CritereAtoutsRepository;
use App\Repository\CritereDiplomeRepository;
use App\Repository\CritereExigenceRepository;
use App\Repository\CritereExperienceRepository;
use App\Repository\MatriceEvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/matrice/evaluation/cv')]
class MatriceEvaluationCvController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private AutreInformationRepository $autreInformationRepository;
    private CritereDiplomeRepository $critereDiplomeRepository;
    private CritereExigenceRepository $critereExigenceRepository;
    private CritereExperienceRepository $critereExperienceRepository;
    private CritereAtoutsRepository $critereAtoutsRepository;
    private MatriceEvaluationRepository $matriceEvaluationRepository;

    public function __construct(EntityManagerInterface $entityManager,AutreInformationRepository $autreInformationRepository, CritereDiplomeRepository $critereDiplomeRepository, CritereExigenceRepository $critereExigenceRepository, CritereExperienceRepository $critereExperienceRepository, CritereAtoutsRepository $critereAtoutsRepository, MatriceEvaluationRepository $matriceEvaluationRepository)
    {
        $this->entityManager = $entityManager;
        $this->autreInformationRepository = $autreInformationRepository;
        $this->critereDiplomeRepository = $critereDiplomeRepository;
        $this->critereExigenceRepository = $critereExigenceRepository;
        $this->critereExperienceRepository = $critereExperienceRepository;
        $this->critereAtoutsRepository = $critereAtoutsRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
    }

    #[Route('/new/{code}', name: 'app_matrice_evaluation_cv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Poste $poste): Response
    {
        $autreInformations = $this->autreInformationRepository->findBy(['deleted'=> false, 'poste' => $poste]);

        if($request->isMethod('POST')){
            $matriceEvaluation = (new MatriceEvaluation())->setPoste($poste);
            $diplomes = json_decode($request->get('diplomes'));
            $experiences = json_decode($request->get('experiences'));
            $exigences = json_decode($request->get('exigences'));
            $atouts = json_decode($request->get('atouts'));
            foreach ($diplomes as $diplome){
                $critereDiplome= (new CritereDiplome())
                    ->setLibelle(trim($diplome->libelle))
                    ->setBareme($diplome->bareme)
                    ->setMatriceEvaluation($matriceEvaluation);
                $this->entityManager->persist($critereDiplome);
            }

            foreach ($experiences as $experience){
                $critereExperience =  (new CritereExperience())
                    ->setLibelle(trim($experience->libelle))
                    ->setBareme($experience->bareme)
                    ->setMatriceEvaluation($matriceEvaluation);
                $this->entityManager->persist($critereExperience);
            }

            foreach ($exigences as $exigence){
                $critereExigence = (new CritereExigence())
                    ->setLibelle(trim($exigence->libelle))
                    ->setBareme($exigence->bareme)
                    ->setMatriceEvaluation($matriceEvaluation);
                $this->entityManager->persist($critereExigence);
            }

            foreach ($atouts as $atout){
                $critereAtout = (new CritereAtouts())
                    ->setLibelle(trim($atout->libelle))
                    ->setBareme($atout->bareme)
                    ->setMatriceEvaluation($matriceEvaluation);
                $this->entityManager->persist($critereAtout);
            }
            $this->entityManager->persist($matriceEvaluation);
            $this->entityManager->flush();
            $this->addFlash('success', 'Enregistrement effectué avec succès');
            return  $this->redirectToRoute('app_poste_index');

        }
        return $this->render('matrice_evaluation_cv/new.html.twig', [
            'poste' => $poste,
            'autre_informations' => $autreInformations
        ]);
    }
    #[Route('/show/{code}', name: 'app_matrice_evaluation_cv_show', methods: ['GET', 'POST'])]
    public function show(Poste $poste){
        $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['poste' => $poste, 'deleted' => false]);
        $critereDiplomes = $this->critereDiplomeRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation]);
        $critereExperiences = $this->critereExperienceRepository->findBy(['deleted' => false, 'matriceEvaluation' =>$matriceEvaluation ]);
        $critereExigences = $this->critereExigenceRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation]);
        $critereAtoutss = $this->critereAtoutsRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation]);
        return  $this->render('matrice_evaluation_cv/show.html.twig',[
            'poste' => $poste,
            'diplomes' => $critereDiplomes,
            'experiences' => $critereExperiences,
            'exigences' => $critereExigences,
            'atouts' => $critereAtoutss
        ]);
    }

}
