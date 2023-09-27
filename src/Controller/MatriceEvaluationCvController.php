<?php

namespace App\Controller;

use App\Entity\Atout;
use App\Entity\AutreExigence;
use App\Entity\CritereAtouts;
use App\Entity\CritereDiplome;
use App\Entity\CritereExigence;
use App\Entity\CritereExperience;
use App\Entity\MatriceEvaluation;
use App\Entity\Poste;
use App\Repository\AtoutRepository;
use App\Repository\AutreExigenceRepository;
use App\Repository\AutreInformationRepository;
use App\Repository\CritereAtoutsRepository;
use App\Repository\CritereDiplomeRepository;
use App\Repository\CritereExigenceRepository;
use App\Repository\CritereExperienceRepository;
use App\Repository\MatriceEvaluationRepository;
use App\Repository\TypeTypeRepository;
use App\Utils\Constants\FixedValuesConstants;
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
    private TypeTypeRepository $typeTypeRepository;
    private AutreExigenceRepository $autreExigenceRepository;

    public function __construct(EntityManagerInterface $entityManager,AutreInformationRepository $autreInformationRepository, CritereDiplomeRepository $critereDiplomeRepository, CritereExigenceRepository $critereExigenceRepository, CritereExperienceRepository $critereExperienceRepository, CritereAtoutsRepository $critereAtoutsRepository, MatriceEvaluationRepository $matriceEvaluationRepository, AtoutRepository $atoutRepository, TypeTypeRepository $typeTypeRepository,AutreExigenceRepository $autreExigenceRepository)
    {
        $this->entityManager = $entityManager;
        $this->autreInformationRepository = $autreInformationRepository;
        $this->critereDiplomeRepository = $critereDiplomeRepository;
        $this->critereExigenceRepository = $critereExigenceRepository;
        $this->critereExperienceRepository = $critereExperienceRepository;
        $this->critereAtoutsRepository = $critereAtoutsRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
        $this->atoutRepository = $atoutRepository;
        $this->typeTypeRepository = $typeTypeRepository;
        $this->autreExigenceRepository = $autreExigenceRepository;
    }

    #[Route('/new/{code}', name: 'app_matrice_evaluation_cv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Poste $poste): Response
    {
        $autreInformationsAtouts = $this->autreInformationRepository->findBy(['deleted'=> false, 'poste' => $poste, 'typeType' => $this->typeTypeRepository->findOneBy(['codeReference' => FixedValuesConstants::TYPE_AUTRE_INFORMATION_ATOUT])]);

        $autreInformationsExigence = $this->autreInformationRepository->findBy(['deleted'=> false, 'poste' => $poste, 'typeType' => $this->typeTypeRepository->findOneBy(['codeReference' => FixedValuesConstants::TYPE_AUTRE_INFORMATION_AUTRE_EXIGENCE])]);

        if($request->isMethod('POST')){
            $matriceEvaluation = (new MatriceEvaluation())->setPoste($poste);
            $diplomes = json_decode($request->get('diplomes'));
            $experiences = json_decode($request->get('experiences'));

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

            if($request->get("critere_exigence")){
                $matriceEvaluation->setCritereExigence(true);
                $exigences = json_decode($request->get('exigences'));
                foreach ($exigences as $exigence){
                    if(!empty($exigence->exigence)){
                        $information = $this->autreInformationRepository->findOneBy(['deleted' => false, 'code'=> $exigence->autre_information]);
                        $critereExigence = (new CritereExigence())
                            ->setAutreInformation($information)
                            ->setMatriceEvaluation($matriceEvaluation);
                        //Les exigences
                        foreach ($exigence->exigence as $item) {
                            $exigenceObjet = (new AutreExigence())
                                ->setLibelle($item->libelle)
                                ->setBareme($item->bareme)
                                ->setCritereExigence($critereExigence);
                            $this->entityManager->persist($exigenceObjet);
                        }
                        $this->entityManager->persist($critereExigence);
                    }
                }
            }
            else{
                $matriceEvaluation->setCritereExigence(false);
            }

            if($request->get("critere_atout")) {
                $matriceEvaluation->setCritereAtout(true);
                $atouts = json_decode($request->get('atouts'));
                foreach ($atouts as $atout){
                    if(!empty($atout->atouts)){
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
                }
            }
            else{
                $matriceEvaluation->setCritereAtout(false);
            }

            $this->entityManager->persist($matriceEvaluation);
            $this->entityManager->flush();
            $this->addFlash('success', 'Enregistrement effectué avec succès');
            return  $this->redirectToRoute('app_poste_index');
        }
        return $this->render('matrice_evaluation_cv/new.html.twig', [
            'poste' => $poste,
            'autre_informations_atouts' => $autreInformationsAtouts,
            'autre_informations_exigence' => $autreInformationsExigence,
        ]);
    }

    #[Route('/update/{code}', name: 'app_matrice_evaluation_cv_update', methods: ['GET', 'POST'])]
    public function update(Poste $poste, Request $request){

        $autreInformationsAtouts = $this->autreInformationRepository->findBy(['deleted'=> false, 'poste' => $poste, 'typeType' => $this->typeTypeRepository->findOneBy(['codeReference' => FixedValuesConstants::TYPE_AUTRE_INFORMATION_ATOUT])]);

        $autreInformationsExigence = $this->autreInformationRepository->findBy(['deleted'=> false, 'poste' => $poste, 'typeType' => $this->typeTypeRepository->findOneBy(['codeReference' => FixedValuesConstants::TYPE_AUTRE_INFORMATION_AUTRE_EXIGENCE])]);

        $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['poste' => $poste, 'deleted' => false]);
        $critereDiplomes = $this->critereDiplomeRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation], ['id' => 'DESC']);
        $critereExperiences = $this->critereExperienceRepository->findBy(['deleted' => false, 'matriceEvaluation' =>$matriceEvaluation ],['id' => 'DESC']);
        $exigencesArray  = [];
        $critereExigences = $this->critereExigenceRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']);
        foreach ($critereExigences as $critereExigence) {
            $exigences = $this->autreExigenceRepository->findBy(['deleted' => false, 'critereExigence' => $critereExigence],['id' => 'DESC']);
            $objet = [
                'critere_exigence' =>$critereExigence,
                'exigences' =>$exigences
            ];
            array_push($exigencesArray,$objet);
        }
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
            //Atouts
            foreach ($atoutsArray as $item) {
                $item['critere_atouts']->setDeleted(true);
                foreach ($item['atouts'] as $atout) {
                    $atout->setDeleted(true);
                }
            }
            // Exigences
            foreach ($exigencesArray as $item) {
                $item['critere_exigence']->setDeleted(true);
                foreach ($item['exigences'] as $atout) {
                    $atout->setDeleted(true);
                }
            }

            // Diplomes
            foreach ($critereDiplomes as $critereDiplome) {
                $critereDiplome->setDeleted(true);
            }
            // Experience
            foreach ($critereExperiences as $critereExperience) {
                $critereExperience->setDeleted(true);
            }
            
            $matriceEvaluation = (new MatriceEvaluation())->setPoste($poste);
            $diplomes = json_decode($request->get('diplomes'));
            $experiences = json_decode($request->get('experiences'));

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

            if($request->get("critere_exigence")){
                $matriceEvaluation->setCritereExigence(true);
                $exigences = json_decode($request->get('exigences'));
                foreach ($exigences as $exigence){
                    if(!empty($exigence->exigence)){
                        $information = $this->autreInformationRepository->findOneBy(['deleted' => false, 'code'=> $exigence->autre_information]);
                        $critereExigence = (new CritereExigence())
                            ->setAutreInformation($information)
                            ->setMatriceEvaluation($matriceEvaluation);
                        //Les exigences
                        foreach ($exigence->exigence as $item) {
                            $exigenceObjet = (new AutreExigence())
                                ->setLibelle($item->libelle)
                                ->setBareme($item->bareme)
                                ->setCritereExigence($critereExigence);
                            $this->entityManager->persist($exigenceObjet);
                        }
                        $this->entityManager->persist($critereExigence);
                    }
                }
            }
            else{
                $matriceEvaluation->setCritereExigence(false);
            }

            if($request->get("critere_atout")) {
                $matriceEvaluation->setCritereAtout(true);
                $atouts = json_decode($request->get('atouts'));
                foreach ($atouts as $atout){
                    if(!empty($atout->atouts)){
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
                }
            }
            else{
                $matriceEvaluation->setCritereAtout(false);
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
            'exigences' => $exigencesArray,
            'atouts' => $atoutsArray,
            'matrice_evaluation' => $matriceEvaluation,
            'autre_informations_atouts' => $autreInformationsAtouts,
            'autre_informations_exigence' => $autreInformationsExigence,
        ]);
    }
}
