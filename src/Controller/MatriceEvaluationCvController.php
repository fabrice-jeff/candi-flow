<?php

namespace App\Controller;

use App\Entity\Atout;
use App\Entity\CritereAtouts;
use App\Entity\CritereDiplome;
use App\Entity\CritereExigence;
use App\Entity\CritereExperience;
use App\Entity\MatriceEvaluation;
use App\Entity\Poste;
use App\Repository\AtoutRepository;
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
    private AtoutRepository $atoutRepository;

    public function __construct(EntityManagerInterface $entityManager,AutreInformationRepository $autreInformationRepository, CritereDiplomeRepository $critereDiplomeRepository, CritereExigenceRepository $critereExigenceRepository, CritereExperienceRepository $critereExperienceRepository, CritereAtoutsRepository $critereAtoutsRepository, MatriceEvaluationRepository $matriceEvaluationRepository, AtoutRepository $atoutRepository)
    {
        $this->entityManager = $entityManager;
        $this->autreInformationRepository = $autreInformationRepository;
        $this->critereDiplomeRepository = $critereDiplomeRepository;
        $this->critereExigenceRepository = $critereExigenceRepository;
        $this->critereExperienceRepository = $critereExperienceRepository;
        $this->critereAtoutsRepository = $critereAtoutsRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
        $this->atoutRepository = $atoutRepository;
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
                $information = $this->autreInformationRepository->findOneBy(['deleted' => false, 'code'=> $atout->autre_information]);

                $critereAtout = (new CritereAtouts())
                    ->setAutreInformation($information)
                    ->setMatriceEvaluation($matriceEvaluation);
                //Les atouts
                foreach ($atout->atouts as $item) {
                    $atoutObjet = (new Atout())
                        ->setLibelle($item->libelle)
                        ->setBareme($item->bareme)
                        ->setCritereAtouts($critereAtout);
                    $this->entityManager->persist($atoutObjet);
                }
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

    #[Route('/update/{code}', name: 'app_matrice_evaluation_cv_update', methods: ['GET', 'POST'])]
    public function update(Poste $poste, Request $request){

        $autreInformations = $this->autreInformationRepository->findBy(['deleted' => false, "poste" => $poste]);
        $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['poste' => $poste, 'deleted' => false]);
        $critereDiplomes = $this->critereDiplomeRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation], ['id' => 'DESC']);
        $critereExperiences = $this->critereExperienceRepository->findBy(['deleted' => false, 'matriceEvaluation' =>$matriceEvaluation ],['id' => 'DESC']);
        $critereExigences = $this->critereExigenceRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']);

        $atoutsArray = [];
        $critereAtouts = $this->critereAtoutsRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']);
        foreach ($critereAtouts as $critereAtout) {
            $atouts = $this->atoutRepository->findBy(['deleted' => false, 'critereAtouts' => $critereAtout],['id' => 'DESC']);
            $objet = [
                'critere_atouts' =>$critereAtout,
                'atouts' =>$atouts
            ];
            array_push($atoutsArray,$objet);
        }
        if($request->isMethod('POST')){
            $matriceEvaluation->setDeleted(true);
            // Pour les diplômes
            foreach ($critereDiplomes as $critereDiplome) {
                $critereDiplome->setDeleted(true);
            }
            //Pour les expériences
            foreach ($critereExperiences as $critereExperience) {
                $critereExperience->setDeleted(true);
            }
            //Pour les exigences
            foreach ($critereExigences as $critereExigence) {
                $critereExigence->setDeleted(true);
            }
            //Pour les atouts
            foreach ($atoutsArray as $item) {
                $item["critere_atouts"]->setDeleted(true);
                foreach ($item['atouts'] as $atout) {
                    $atout->setDeleted(true);
                }
            }

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
                $information = $this->autreInformationRepository->findOneBy(['deleted' => false, 'code'=> $atout->autre_information]);

                $critereAtout = (new CritereAtouts())
                    ->setAutreInformation($information)
                    ->setMatriceEvaluation($matriceEvaluation);
                //Les atouts
                foreach ($atout->atouts as $item) {
                    $atoutObjet = (new Atout())
                        ->setLibelle($item->libelle)
                        ->setBareme($item->bareme)
                        ->setCritereAtouts($critereAtout);
                    $this->entityManager->persist($atoutObjet);
                }
                $this->entityManager->persist($critereAtout);
            }

            $this->entityManager->persist($matriceEvaluation);
            $this->entityManager->flush();
            $this->addFlash('success', 'Enregistrement effectué avec succès');
            return  $this->redirectToRoute('app_poste_index');
        }

        return  $this->render('matrice_evaluation_cv/update.html.twig',[
            'poste' => $poste,
            'diplomes' => $critereDiplomes,
            'experiences' => $critereExperiences,
            'exigences' => $critereExigences,
            'atouts' => $atoutsArray,
            'autre_informations' =>$autreInformations
        ]);
    }
}
