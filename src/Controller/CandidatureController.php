<?php

namespace App\Controller;

use App\Entity\AutreInformationCandidature;
use App\Entity\Formation;
use App\Entity\OutilInformatiqueCandidature;
use App\Entity\ParcoursGlobal;
use App\Entity\ParcoursSpecifique;
use App\Entity\PieceManquante;
use App\Entity\Poste;
use App\Entity\Candidature;
use App\Entity\TotalExperience;
use App\Form\CandidatureType;
use App\Repository\AutreInformationCandidatureRepository;
use App\Repository\AutreInformationRepository;
use App\Repository\CritereAtoutsRepository;
use App\Repository\CritereDiplomeRepository;
use App\Repository\CritereExigenceRepository;
use App\Repository\CritereExperienceRepository;
use App\Repository\FormationRepository;
use App\Repository\MatriceEvaluationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\OutilInformatiqueCandidatureRepository;
use App\Repository\ParcoursGlobalRepository;
use App\Repository\ParcoursSpecifiqueRepository;
use App\Repository\StatutRepository;
use App\Repository\TotalExperienceRepository;
use App\Utils\Constants\FixedValuesConstants;
use ContainerNSYwJO4\getConsole_ErrorListenerService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use App\Repository\OutilsInformatiqueRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidature')]
class CandidatureController extends AbstractController
{
    private AutreInformationRepository $autreInformationRepository;
    private CandidatureRepository $candidatureRepository;
    private EntityManagerInterface $manager;
    private OutilsInformatiqueRepository $outilsInformatiqueRepository;
    private NiveauEtudeRepository $niveauEtudeRepository;
    private FormationRepository $formationRepository;
    private TotalExperienceRepository $totalExperienceRepository;
    private ParcoursGlobalRepository $parcoursGlobalRepository;
    private ParcoursSpecifiqueRepository $parcoursSpecifiqueRepository;
    private OutilInformatiqueCandidatureRepository $outilInformatiqueCandidatureRepository;
    private AutreInformationCandidatureRepository $autreInformationCandidatureRepository;
    private StatutRepository $statutRepository;
    private MatriceEvaluationRepository $matriceEvaluationRepository;
    private CritereDiplomeRepository $critereDiplomeRepository;
    private CritereExperienceRepository $critereExperienceRepository;
    private CritereExigenceRepository $critereExigenceRepository;
    private CritereAtoutsRepository $critereAtoutsRepository;

    public function __construct(AutreInformationRepository $autreInformationRepository,CandidatureRepository $candidatureRepository, EntityManagerInterface $manager, OutilsInformatiqueRepository $outilsInformatiqueRepository, NiveauEtudeRepository $niveauEtudeRepository, FormationRepository $formationRepository, TotalExperienceRepository $totalExperienceRepository, OutilInformatiqueCandidatureRepository $outilInformatiqueCandidatureRepository, ParcoursGlobalRepository $parcoursGlobalRepository, ParcoursSpecifiqueRepository $parcoursSpecifiqueRepository, AutreInformationCandidatureRepository $autreInformationCandidatureRepository, StatutRepository $statutRepository, MatriceEvaluationRepository $matriceEvaluationRepository, CritereDiplomeRepository $critereDiplomeRepository,  CritereExperienceRepository $critereExperienceRepository, CritereExigenceRepository $critereExigenceRepository, CritereAtoutsRepository $critereAtoutsRepository)
    {
        $this->autreInformationRepository = $autreInformationRepository;
        $this->candidatureRepository = $candidatureRepository;
        $this->manager = $manager;
        $this->outilsInformatiqueRepository = $outilsInformatiqueRepository;
        $this->niveauEtudeRepository = $niveauEtudeRepository;
        $this->formationRepository = $formationRepository;
        $this->totalExperienceRepository = $totalExperienceRepository;
        $this->parcoursGlobalRepository = $parcoursGlobalRepository;
        $this->parcoursSpecifiqueRepository = $parcoursSpecifiqueRepository;
        $this->outilInformatiqueCandidatureRepository = $outilInformatiqueCandidatureRepository;
        $this->autreInformationCandidatureRepository = $autreInformationCandidatureRepository;
        $this->statutRepository = $statutRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
        $this->critereDiplomeRepository = $critereDiplomeRepository;
        $this->critereExperienceRepository = $critereExperienceRepository;
        $this->critereExigenceRepository = $critereExigenceRepository;
        $this->critereAtoutsRepository = $critereAtoutsRepository;
    }

    #[Route('/liste/{code}', name: 'app_candidature_index', methods: ['GET','POST'])]
    public function index(Request $request, Poste $poste): Response
    {
        $critere = $poste->getCritere();
        $autresInformations = $this->autreInformationRepository->findBy(['poste' => $poste, 'deleted' => false]);
        $candidaturesArray = [];
        $statut = $this->statutRepository->findOneBy(['codeReference' => FixedValuesConstants::STATUT_CANDIDATURE_EN_ATTENTE]);
        $candidatures =  $this->candidatureRepository->findBy(['deleted' => false, 'statut' => $statut, 'poste' => $poste]);
        foreach ($candidatures as $candidature){
            $formations = $this->formationRepository->findBy(['deleted' => false, 'candidature' =>$candidature ]);
            $parcoursGlobal =  $this->parcoursGlobalRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $totalExperience =  $this->totalExperienceRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $outilsInformatiquesCandi =  $this->outilInformatiqueCandidatureRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $parcoursSpecifiques =  $this->parcoursSpecifiqueRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $autreInformationCandidature = $this->autreInformationCandidatureRepository->findBy(['candidature' => $candidature]);
            $objetCandidatures = [
                'candidature' => $candidature,
                'formations' => $formations,
                'parcours_global' => $parcoursGlobal,
                'parcours_specfique' => $parcoursSpecifiques,
                'total_experience' => $totalExperience,
                'outils_candidatures' => $outilsInformatiquesCandi,
                'autre_information_candidatures' => $autreInformationCandidature,
            ];
            array_push($candidaturesArray, $objetCandidatures);
        }

        $form =  $this->createFormBuilder()
            ->add('justification', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Justification de la décision"
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $candidature  = $this->candidatureRepository->findOneBy(['deleted' => false, 'code' => $request->get('code-candidature')]);
            if($request->get('oui')){
                $candidature->setDossierComplet(true);
            }
            else{
                $candidature->setDossierComplet(false);
                $piecesManquantes = json_decode($request->get('pieces-manquantes'));
                // Enregistrer les pieces manquantes
                foreach ($piecesManquantes as $value) {
                    $piece = (new PieceManquante())
                        ->setCandidature($candidature)
                        ->setNomPiece($value);
                    $this->manager->persist($piece);
                }
            }
            if($request->get('accepte')) {
                $candidature->setDecision(true);
            }
            else {
                $candidature->setDecision(false);
            }
            $candidature->setJustification($request->get('form')['justification']);
            $candidature->setStatut($this->statutRepository->findOneBy(['codeReference' => FixedValuesConstants::STATUT_CANDIDATURE_TRAITER]));
            $this->addFlash('success', 'Enregistrement effectué avec succès');
            $this->manager->flush();
            return $this->redirectToRoute('app_candidature_traite', [
                'code' => $poste->getCode()
            ]);
        }
        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidaturesArray,
            'critere' => $critere,
            'poste' => $poste,
            'autres_informations' => $autresInformations,
            'form' =>  $form
        ]);
    }

    #[Route('/candidature-traite/{code}', name: 'app_candidature_traite', methods: ['GET','POST'])]
    public function candidatureTraite(Request $request, Poste $poste): Response
    {
        $critere = $poste->getCritere();
        $autresInformations = $this->autreInformationRepository->findBy(['poste' => $poste, 'deleted' => false]);
        $candidaturesArray = [];
        $statut = $this->statutRepository->findOneBy(['codeReference' => FixedValuesConstants::STATUT_CANDIDATURE_TRAITER]);
        $candidatures =  $this->candidatureRepository->findBy(['deleted' => false, 'statut' => $statut, 'poste' => $poste]);
        foreach ($candidatures as $candidature){
            $formations = $this->formationRepository->findBy(['deleted' => false, 'candidature' =>$candidature ]);
            $parcoursGlobal =  $this->parcoursGlobalRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $totalExperience =  $this->totalExperienceRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $outilsInformatiquesCandi =  $this->outilInformatiqueCandidatureRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $parcoursSpecifiques =  $this->parcoursSpecifiqueRepository->findBy(['deleted' => false, 'candidature' => $candidature]);
            $autreInformationCandidature = $this->autreInformationCandidatureRepository->findBy(['candidature' => $candidature]);
            $objetCandidatures = [
                'candidature' => $candidature,
                'formations' => $formations,
                'parcours_global' => $parcoursGlobal,
                'parcours_specfique' => $parcoursSpecifiques,
                'total_experience' => $totalExperience,
                'outils_candidatures' => $outilsInformatiquesCandi,
                'autre_information_candidatures' => $autreInformationCandidature,
            ];
            array_push($candidaturesArray, $objetCandidatures);
        }

        return $this->render('candidature/candidature_traite.html.twig', [
            'candidatures' => $candidaturesArray,
            'critere' => $critere,
            'poste' => $poste,
            'autres_informations' => $autresInformations,
        ]);
    }

    #[Route('/new/{code}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Poste $poste,): Response
    {
        $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['deleted' => false, 'poste' => $poste]);
        $critereDiplome =  $this->critereDiplomeRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation], ['id' => 'DESC']);
        $critereExperience = $this->critereExperienceRepository->findBy(['deleted' => false, 'matriceEvaluation'  => $matriceEvaluation],['id' => 'DESC']);
        $critereExigence = $this->critereExigenceRepository->findBy(['deleted' =>false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']);
        $critereAtout = $this->critereAtoutsRepository->findBy(['deleted' => false,  'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']);
        $candidature = new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);
        $outilsInformatiques = $this->outilsInformatiqueRepository->findBy(['deleted' =>false]);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($candidature);
            $this->manager->flush();
            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }
        $autresInformations = $this->autreInformationRepository->findBy(['poste' => $poste, 'deleted' => false]);
        if($form->isSubmitted()){
            $critere = $poste->getCritere();
            if($critere->isNomPrenoms()){
                $candidature->setNom($request->get('candidature')['nom'])
                    ->setPrenom($request->get('candidature')['prenom']);
            }
            if($critere->isNationalite()){
                $candidature->setNationalite($request->get('candidature')['nationalite']);
            }
            if($critere->isSexe()){
                $candidature->setSexe($request->get('candidature')['sexe']);
            }
            if($critere->isEmail()){
                $candidature->setEmail($request->get('candidature')['email']);
            }
            if($critere->isDateNissance()){
                $candidature->setDateNaissance(new \DateTime($request->get('date_naissance')));
            }
            if($critere->isContact()){
                $candidature->setContact($request->get('candidature')['contact']);
            }
            if($critere->isDiplome()){
                if($request->get('candidature')['niveauEtude']){
                    $candidature->setNiveauEtude($this->niveauEtudeRepository->findOneBy(['deleted' => false, 'id' => $request->get('candidature')['niveauEtude']]));
                }
                if($request->get('candidature')['domaine']){
                    $candidature->setDomaine($request->get('candidature')['domaine']);
                }
            }
            if($critere->isLogicielSpecifique()){
                ($request->get('logiciel-specifique')) ? $candidature->setLogicielSpecifique(true) : $candidature->setLogicielSpecifique(false);
            }
            if($critere->isFormationPoste()){
                $formations = json_decode($request->get('formations-poste'));
                foreach ($formations as $value) {
                    $formation = (new Formation())
                        ->setLibelle($value)
                        ->setCandidature($candidature);
                    $this->manager->persist($formation);
                }
            }
            if ($critere->isAutreOutils()){
                foreach ($outilsInformatiques as $outilsInformatique) {
                    if($request->get($outilsInformatique->getCode())){
                        $outilInformatiqueCandidature = (new OutilInformatiqueCandidature())
                            ->setCandidature($candidature)
                            ->setOutilInformatique($outilsInformatique);
                        $this->manager->persist($outilInformatiqueCandidature);
                    }
                }
            }
            if($critere->isTotalExperiance()){
                $totalExperiences = json_decode($request->get('total-experience'));
                foreach ($totalExperiences as $experience) {
                    $totalExperience = (new TotalExperience())
                        ->setDuree($experience->duree)
                        ->setPoste($experience->poste)
                        ->setOrganisme($experience->organisme)
                        ->setCandidature($candidature);
                    if(!($experience->precision == "Aucun")){
                        $totalExperience->setPrecisionPoste($experience->precision);
                    }
                    $this->manager->persist($totalExperience);
                }
            }
            if ($critere->isParcoursGlobal()){
                $parcoursGlobals = json_decode($request->get('parcours-global'));
                foreach ($parcoursGlobals as $parcoursGlobal) {
                    $parcoursGlobalCandidature = (new ParcoursGlobal())
                        ->setCandidature($candidature)
                        ->setLibelle($parcoursGlobal);
                    $this->manager->persist($parcoursGlobalCandidature);
                }
            }
            if ($critere->isParcoursSpecifique()){
                $parcoursSpecifiques = json_decode($request->get('parcours-specifique'));
                foreach ($parcoursSpecifiques as $parcoursSpecifique) {
                    $parcoursSpecifiqueCandidature = (new ParcoursSpecifique())
                        ->setCandidature($candidature)
                        ->setLibelle($parcoursSpecifique);
                    $this->manager->persist($parcoursSpecifiqueCandidature);
                }
            }
            if($critere->isAutreInformation()){
                foreach ($autresInformations as $information) {
                    if($request->get($information->getCode())){
                        $autresInformationCandidature = (new AutreInformationCandidature())
                            ->setCandidature($candidature)
                            ->setAutreInformation($information)
                            ->setChecked(true);
                        $this->manager->persist($autresInformationCandidature);
                    }
                    else{
                        $autresInformationCandidature = (new AutreInformationCandidature())
                            ->setCandidature($candidature)
                            ->setAutreInformation($information)
                            ->setChecked(false);
                        $this->manager->persist($autresInformationCandidature);
                    }
                }
            }
            $dateDepot = new \DateTime($request->get('date_depot_dossier'));

            $candidature->setPoste($poste)->setDateDepotDossier($dateDepot);
            $candidature->setStatut($this->statutRepository->findOneBy(['codeReference' => FixedValuesConstants::STATUT_CANDIDATURE_EN_ATTENTE]));
            $dateFin = date_format($poste->getDateFin(), 'Y');
            $age = $dateFin - date_format(new \DateTime($request->get('date_naissance')),'Y');
            $candidature->setAge($age);
            $diplome = $this->critereDiplomeRepository->findOneBy(['deleted' => false, 'code' => $request->get('diplome') ]);
            $atout = $this->critereAtoutsRepository->findOneBy(['deleted' => false, 'code'=>$request->get('atout')]);
            $experience = $this->critereExperienceRepository->findOneBy(['deleted'=> false, 'code' =>$request->get('experience')]);
            $exigence = $this->critereExigenceRepository->findOneBy(['deleted' => false,  'code' => $request->get('exigence')]);
            $note = $diplome->getBareme()+$atout->getBareme()+$experience->getBareme()+$exigence->getBareme();
            $candidature->setNote($note);
            $this->manager->persist($candidature);
            $this->manager->flush();
            $this->addFlash('success', "Enregistrement effectué avec Succès!!");
            return $this->redirectToRoute('app_candidature_index', [
                'code' => $poste->getCode()
            ]);

        }
        return $this->render('candidature/new.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
            'poste' => $poste,
            'outils_informatiques' => $outilsInformatiques,
            'autres_informations' => $autresInformations,
            'citeres_diplome' => $critereDiplome,
            'critere_experience' => $critereExperience,
            'critere_exigence' => $critereExigence,
            'critere_atout' => $critereAtout,
        ]);
    }

}
