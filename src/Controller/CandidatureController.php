<?php

namespace App\Controller;

use App\Entity\AutreInformationCandidature;
use App\Entity\Formation;
use App\Entity\OutilInformatiqueCandidature;
use App\Entity\ParcoursGlobal;
use App\Entity\ParcoursSpecifique;
use App\Entity\Poste;
use App\Entity\Candidature;
use App\Entity\TotalExperience;
use App\Form\CandidatureType;
use App\Repository\AutreInformationCandidatureRepository;
use App\Repository\AutreInformationRepository;
use App\Repository\FormationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\OutilInformatiqueCandidatureRepository;
use App\Repository\ParcoursGlobalRepository;
use App\Repository\ParcoursSpecifiqueRepository;
use App\Repository\TotalExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use App\Repository\OutilsInformatiqueRepository;
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

    public function __construct(AutreInformationRepository $autreInformationRepository,CandidatureRepository $candidatureRepository, EntityManagerInterface $manager, OutilsInformatiqueRepository $outilsInformatiqueRepository, NiveauEtudeRepository $niveauEtudeRepository, FormationRepository $formationRepository, TotalExperienceRepository $totalExperienceRepository, OutilInformatiqueCandidatureRepository $outilInformatiqueCandidatureRepository, ParcoursGlobalRepository $parcoursGlobalRepository, ParcoursSpecifiqueRepository $parcoursSpecifiqueRepository, AutreInformationCandidatureRepository $autreInformationCandidatureRepository)
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
    }

    #[Route('/liste/{code}', name: 'app_candidature_index', methods: ['GET'])]
    public function index(Poste $poste,): Response
    {
        $critere = $poste->getCritere();
        $autresInformations = $this->autreInformationRepository->findBy(['poste' => $poste, 'deleted' => false]);
        $candidaturesArray = [];
        $candidatures =  $this->candidatureRepository->findAll();
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
                ]
            ])
            ->getForm();

        return $this->render('candidature/index.html.twig', [
            'candidatures' => $candidaturesArray,
            'critere' => $critere,
            'poste' => $poste,
            'autres_informations' => $autresInformations,
            'form' =>  $form
        ]);
    }

    #[Route('/new/{code}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Poste $poste,): Response
    {
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
                        ->setCandidature($candidature)
                        ->setPrecisionPoste($experience->organisme);
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
                            ->setAutreInformation($information);
                        $this->manager->persist($autresInformationCandidature);
                    }
                }
            }
            $dateDepot = new \DateTime($request->get('date_depot_dossier'));

            $candidature->setPoste($poste)->setDateDepotDossier($dateDepot);

            $this->manager->persist($candidature);
//            dd($candidature);
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
            'autres_informations' => $autresInformations
        ]);
    }

}
