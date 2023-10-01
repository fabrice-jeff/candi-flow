<?php

namespace App\Controller;

use App\Entity\Atout;
use App\Entity\AutreExigence;
use App\Entity\AutreInformation;
use App\Entity\Critere;
use App\Entity\CritereAtouts;
use App\Entity\CritereDiplome;
use App\Entity\CritereExigence;
use App\Entity\CritereExperience;
use App\Entity\MatriceEvaluation;
use App\Entity\NiveauEtude;
use App\Entity\ParcoursGlobal;
use App\Entity\ParcoursSpecifique;
use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\AtoutRepository;
use App\Repository\AutreExigenceRepository;
use App\Repository\AutreInformationRepository;
use App\Repository\CritereAtoutsRepository;
use App\Repository\CritereDiplomeRepository;
use App\Repository\CritereExigenceRepository;
use App\Repository\CritereExperienceRepository;
use App\Repository\MatriceEvaluationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\PoliceRepository;
use App\Repository\PosteRepository;
use App\Repository\TypeTypeRepository;
use App\Services\AppServices;
use App\Utils\Constants\FixedValuesConstants;
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
    private TypeTypeRepository $typeTypeRepository;
    private MatriceEvaluationRepository $matriceEvaluationRepository;
    private AutreInformationRepository $autreInformationRepository;
    private CritereAtoutsRepository $critereAtoutsRepository;
    private CritereExigenceRepository $critereExigenceRepository;
    private AtoutRepository $atoutRepository;
    private AutreExigenceRepository $autreExigenceRepository;
    private CritereDiplomeRepository $critereDiplomeRepository;
    private CritereExperienceRepository $critereExperienceRepository;
    private PoliceRepository $policeRepository;
    private AppServices $appServices;

    public function __construct(TypeTypeRepository $typeTypeRepository, MatriceEvaluationRepository $matriceEvaluationRepository, AutreInformationRepository $autreInformationRepository, CritereAtoutsRepository $critereAtoutsRepository,  CritereExigenceRepository $critereExigenceRepository, AtoutRepository $atoutRepository, AutreExigenceRepository $autreExigenceRepository, CritereDiplomeRepository $critereDiplomeRepository, CritereExperienceRepository $critereExperienceRepository,PoliceRepository $policeRepository, AppServices $appServices)
    {
        $this->typeTypeRepository = $typeTypeRepository;
        $this->matriceEvaluationRepository = $matriceEvaluationRepository;
        $this->autreInformationRepository = $autreInformationRepository;
        $this->critereAtoutsRepository = $critereAtoutsRepository;
        $this->critereExigenceRepository = $critereExigenceRepository;
        $this->atoutRepository = $atoutRepository;
        $this->autreExigenceRepository = $autreExigenceRepository;
        $this->critereDiplomeRepository = $critereDiplomeRepository;
        $this->critereExperienceRepository = $critereExperienceRepository;
        $this->policeRepository = $policeRepository;
        $this->appServices = $appServices;
    }

    #[Route('/', name: 'app_poste_index', methods: ['GET'])]
    public function index(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/index.html.twig', [
            'postes' => $posteRepository->findBy(['deleted' => false]),
        ]);
    }

    #[Route('/new', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NiveauEtudeRepository $niveauEtudeRepository,): Response
    {
        $typeAutreInformation = $this->typeTypeRepository->findBy(['parent' => FixedValuesConstants::TYPE_AUTRE_INFORMATION]);
        $poste = new Poste();
        $form = $this->createForm(PosteType::class);
        $form->handleRequest($request);
        $polices =  $this->policeRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
//            dd($request);
            $critere = new Critere();
            $poste->setLibelle($request->get('poste')['libelle']);
            ($request->get('nomPrenom')) ? $critere->setNomPrenoms(true) : $critere->setNomPrenoms(false);
            ($request->get('nationalite')) ? $critere->setNationalite(true) : $critere->setNationalite(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);

            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
                $poste->setDateFin((new \DateTime($request->get('dateFin'))));
            }
            else{
                $critere->setAgeExige(false);
            }
            ($request->get('contact')) ? $critere->setContact(true) : $critere->setContact(false);

            if($request->get('diplome')){
                $critere->setDiplome(true);
                $poste->setNiveauEtude($niveauEtudeRepository->find($request->get('poste')['niveauEtude']));
                $poste->setDomaine($request->get('poste')['domaine']);
            }
            else{
                $critere->setDiplome(false);
            }
            if($request->get('formation_poste')){
                $critere->setFormationPoste(true);
                $poste->setNombreFormation($request->get('poste')['nombreFormation']);
            }else{
                $critere->setFormationPoste(false);
            }
            if($request->get('logiciel-specifique')){
                $critere->setLogicielSpecifique(true);
                $poste->setLogicielSpecifique($request->get('poste')['logicielSpecifique']);
            }
            else{
                $critere->setLogicielSpecifique(false);
            }
            ($request->get('autre-outils')) ? $critere->setAutreOutils(true) : $critere->setAutreOutils(false);
            ($request->get('total-experience-cv')) ? $critere->setTotalExperiance(true) : $critere->setTotalExperiance(false);
            if($request->get('parcours-global')){
                $critere->setParcoursGlobal(true);
                $poste->setDureeParcoursGlobal($request->get('poste')['dureeParcoursGlobal']);
                $poste->setPosteParcoursGlobal($request->get('poste')['posteParcoursGlobal']);
            }
            else{
                $critere->setParcoursGlobal(false);
            }
            if($request->get('parcours-specifique')){
                $critere->setParcoursSpecifique(true);
                $poste->setDureeParcoursSpecifique($request->get('poste')['dureeParcoursSpecifique']);
                $poste->setPosteParcoursSpecifique($request->get('poste')['posteParcoursSpecifique']);
            }
            else{
                $critere->setParcoursSpecifique(false);
            }
            if($request->get('connaissance')){
                $critere->setAutreInformation(true);
                //Enregistrer les autres informations( Autres exigences ou Atouts)
                $autresInformations = json_decode($request->get('poste_connaissance'));
                foreach ($autresInformations as $objet) {
                    $type =  $this->typeTypeRepository->findOneBy(['codeReference'=>$objet->type]);
                    $autreInformation = (new AutreInformation())
                        ->setNomColonne($objet->nom)
                        ->setInformation($objet->domaine)
                        ->setTypeType($type)
                        ->setPoste($poste);
                    $entityManager->persist($autreInformation);
                }
            }
            else{
                $critere->setAutreInformation(false);
            }
            ($request->get('decision')) ? $critere->setDecision(true) : $critere->setDecision(false);
            ($request->get('dossier-complet')) ? $critere->setDossierComplet(true) : $critere->setDossierComplet(false);
            ($request->get('justification')) ? $critere->setJustification(true) : $critere->setJustification(false);
            ($request->get('gras'))? $poste->setGras(true) : $poste->setGras(false);
            $poste->setPolice($this->policeRepository->find($request->get('police_critere')));

            $colorString = $request->get('color_critere');
            $hexColor = $this->appServices->hsvStringToHex($colorString);


            $poste->setCouleurCritere($hexColor);
            $poste->setCritere($critere);
            $entityManager->persist($poste);
            $entityManager->persist($critere);
            $entityManager->flush();
            $this->addFlash('success', "Poste enregistrée avec succès");
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/new.html.twig', [
            'type_autre_information'  => $typeAutreInformation,
            'poste' => $poste,
            'form' => $form,
            'polices' => $polices,
        ]);
    }

    #[Route('/update/{code}', name: 'app_poste_update', methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $entityManager, NiveauEtudeRepository $niveauEtudeRepository,AutreInformationRepository $autreInformationRepository, Poste $poste): Response
    {
        $polices =  $this->policeRepository->findAll();
        $typeAutreInformation =  $this->typeTypeRepository->findBy(['parent' => FixedValuesConstants::TYPE_AUTRE_INFORMATION]) ;
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        $informationComplementaires =  $autreInformationRepository->findBy(['deleted' => false, 'poste' =>$poste], ['id' => 'DESC']);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * Récuperer toute les autres informations concernant l'ancien objet Poste
             * dans des variables
             * Mettre les deleted des objets même à true
            */
            $matriceEvaluation = $this->matriceEvaluationRepository->findOneBy(['deleted'=> false, 'poste'=>$poste]);

            $criterExperiences =  $this->critereExperienceRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation]);
            $critereDiplomes = $this->critereDiplomeRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation]);

            $exigencesArray  = [];
            foreach ($this->critereExigenceRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']) as $critereExigence) {
                $exigences = $this->autreExigenceRepository->findBy(['deleted' => false, 'critereExigence' => $critereExigence],['id' => 'DESC']);
                $objet = [
                    'critere_exigence' =>$critereExigence,
                    'exigences' =>$exigences
                ];
                array_push($exigencesArray,$objet);
            }
            $atoutsArray = [];
            foreach ($this->critereAtoutsRepository->findBy(['deleted' => false, 'matriceEvaluation' => $matriceEvaluation],['id' => 'DESC']) as $critereAtout) {
                $atouts = $this->atoutRepository->findBy(['deleted' => false, 'critereAtouts' => $critereAtout],['id' => 'DESC']);
                $objet = [
                    'critere_atouts' =>$critereAtout,
                    'atouts' =>$atouts
                ];
                array_push($atoutsArray,$objet);
            }
            if($matriceEvaluation){
                $matriceEvaluation->setDeleted(true);
                //Les expériences
                foreach ($criterExperiences as $criterExperience) {
                    $criterExperience->setDeleted(true);
                }
                //Les diplomes
                foreach ($critereDiplomes as $critereDiplome) {
                    $critereDiplome->setDeleted(true);
                }
                //Autres informations
                foreach ($informationComplementaires as $informationComplementaire) {
                    $informationComplementaire->setDeleted(true);
                }
                // Atouts
                foreach ($atoutsArray as $item) {
                    $item['critere_atouts']->setDeleted(true);
                    foreach ($item['atouts'] as $atout) {
                        $atout->setDeleted(true);
                    }
                }
                //Exigence
                foreach ($exigencesArray as $item) {
                    $item['critere_exigence']->setDeleted(true);
                    foreach ($item['exigences'] as $exigence) {
                        $exigence->setDeleted(true);
                    }
                }
            }
            $poste->getCritere()->setDeleted(true);
            $poste->setDeleted(true);

            /**
             * Enregistrer le nouvel objet Poste
             * Recuperer  toutes les informations concernant concernant l'ancien obje depuis les variable
             * Mettre ces informations dans le nouveau poste lors de l'enregistrement
             */

            $critere = new Critere();
            $poste = new Poste();
            if($matriceEvaluation){
                $matriceEvaluationNew =(new MatriceEvaluation())
                    ->setPoste($poste)
                    ->setCritereAtout($matriceEvaluation->isCritereAtout())
                    ->setCritereExigence($matriceEvaluation->isCritereExigence());

                //Pour les diplomes
                foreach ($critereDiplomes as $critereDiplome) {
                    $critereDiplomeNew =  (new CritereDiplome())
                        ->setMatriceEvaluation($matriceEvaluationNew)
                        ->setLibelle($critereDiplome->getLibelle())
                        ->setBareme($critereDiplome->getBareme());
                    $entityManager->persist($critereDiplomeNew);
                }

                //Les expériences
                foreach ($criterExperiences as $critereExperience) {
                    $critereExperienceNew =  (new CritereExperience())
                        ->setMatriceEvaluation($matriceEvaluationNew)
                        ->setLibelle($critereExperience->getLibelle())
                        ->setBareme($critereExperience->getBareme());
                    $entityManager->persist($critereExperienceNew);
                }$matriceEvaluationNew =(new MatriceEvaluation())
                    ->setPoste($poste)
                    ->setCritereAtout($matriceEvaluation->isCritereAtout())
                    ->setCritereExigence($matriceEvaluation->isCritereExigence());

                //Pour les diplomes
                foreach ($critereDiplomes as $critereDiplome) {
                    $critereDiplomeNew =  (new CritereDiplome())
                        ->setMatriceEvaluation($matriceEvaluationNew)
                        ->setLibelle($critereDiplome->getLibelle())
                        ->setBareme($critereDiplome->getBareme());
                    $entityManager->persist($critereDiplomeNew);
                }

                //Les expériences
                foreach ($criterExperiences as $critereExperience) {
                    $critereExperienceNew =  (new CritereExperience())
                        ->setMatriceEvaluation($matriceEvaluationNew)
                        ->setLibelle($critereExperience->getLibelle())
                        ->setBareme($critereExperience->getBareme());
                    $entityManager->persist($critereExperienceNew);
                }
            }

            $poste->setLibelle($request->get('poste')['libelle']);
            ($request->get('nomPrenom')) ? $critere->setNomPrenoms(true) : $critere->setNomPrenoms(false);
            ($request->get('nationalite')) ? $critere->setNationalite(true) : $critere->setNationalite(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);

            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
                $poste->setDateFin((new \DateTime($request->get('dateFin'))));
            }
            else{
                $critere->setAgeExige(false);
            }
            ($request->get('contact')) ? $critere->setContact(true) : $critere->setContact(false);

            if($request->get('diplome')){
                $critere->setDiplome(true);
                $poste->setNiveauEtude($niveauEtudeRepository->find($request->get('poste')['niveauEtude']));
                $poste->setDomaine($request->get('poste')['domaine']);
            }
            else{
                $critere->setDiplome(false);
            }
            if($request->get('formation_poste')){
                $critere->setFormationPoste(true);
                $poste->setNombreFormation($request->get('poste')['nombreFormation']);
            }else{
                $critere->setFormationPoste(false);
            }
            if($request->get('logiciel-specifique')){
                $critere->setLogicielSpecifique(true);
                $poste->setLogicielSpecifique($request->get('poste')['logicielSpecifique']);
            }
            else{
                $critere->setLogicielSpecifique(false);
            }
            ($request->get('autre-outils')) ? $critere->setAutreOutils(true) : $critere->setAutreOutils(false);
            ($request->get('total-experience-cv')) ? $critere->setTotalExperiance(true) : $critere->setTotalExperiance(false);
            if($request->get('parcours-global')){
                $critere->setParcoursGlobal(true);
                $poste->setDureeParcoursGlobal($request->get('poste')['dureeParcoursGlobal']);
                $poste->setPosteParcoursGlobal($request->get('poste')['posteParcoursGlobal']);
            }
            else{
                $critere->setParcoursGlobal(false);
            }
            if($request->get('parcours-specifique')){
                $critere->setParcoursSpecifique(true);
                $poste->setDureeParcoursSpecifique($request->get('poste')['dureeParcoursSpecifique']);
                $poste->setPosteParcoursSpecifique($request->get('poste')['posteParcoursSpecifique']);
            }
            else{
                $critere->setParcoursSpecifique(false);
            }
            if($request->get('connaissance')){
                $critere->setAutreInformation(true);
                //Enregistrer les connaisances
                $autresInformations = json_decode($request->get('poste_connaissance'));
                foreach ($autresInformations as $objet) {
                    $type =  $this->typeTypeRepository->findOneBy(['codeReference'=>$objet->type]);
                    $autreInformation = (new AutreInformation())
                        ->setNomColonne($objet->nom)
                        ->setInformation($objet->domaine)
                        ->setTypeType($type)
                        ->setPoste($poste);
                    if($type->getCodeReference() == FixedValuesConstants::TYPE_AUTRE_INFORMATION_AUTRE_EXIGENCE){
                        // Les exigences
                        foreach ($exigencesArray as $item) {
                            $critereExigenceNew = (new CritereExigence())
                                ->setMatriceEvaluation($matriceEvaluationNew)
                                ->setAutreInformation($autreInformation);
                            foreach ($item['exigences'] as  $value) {
                                $exigenceNew = (new AutreExigence())
                                    ->setCritereExigence($critereExigenceNew)
                                    ->setLibelle($value->getLibelle())
                                    ->setBareme($value->getBareme());
                                $entityManager->persist($exigenceNew);
                            }
                            $entityManager->persist($critereExigenceNew);
                        }
                    }

                    if($type->getCodeReference() == FixedValuesConstants::TYPE_AUTRE_INFORMATION_ATOUT){
                        //Les atouts
                        foreach ($atoutsArray as $item) {
                            $critereAtoutNew = (new CritereAtouts())
                                ->setMatriceEvaluation($matriceEvaluationNew)
                                ->setAutreInformation($autreInformation);
                            foreach ($item['atouts'] as  $value) {
                                $atoutNew = (new Atout())
                                    ->setCritereAtouts($critereAtoutNew)
                                    ->setLibelle($value->getLibelle())
                                    ->setBareme($value->getBareme());
                                $entityManager->persist($atoutNew);
                            }
                            $entityManager->persist($critereAtoutNew);
                        }
                    }

                    $entityManager->persist($autreInformation);
                }
            }
            else{
                $critere->setAutreInformation(false);
            }
            ($request->get('decision')) ? $critere->setDecision(true) : $critere->setDecision(false);
            ($request->get('dossier-complet')) ? $critere->setDossierComplet(true) : $critere->setDossierComplet(false);
            ($request->get('justification')) ? $critere->setJustification(true) : $critere->setJustification(false);
            ($request->get('gras'))? $poste->setGras(true) : $poste->setGras(false);
            $poste->setPolice($this->policeRepository->find($request->get('police_critere')));
            $colorString = $request->get('color_critere');
            $hexColor = $this->appServices->hsvStringToHex($colorString);
            $poste->setCouleurCritere($hexColor);
            $poste->setCritere($critere);
            if($matriceEvaluation){
                $entityManager->persist($matriceEvaluationNew);
            }
            $entityManager->persist($poste);
            $entityManager->persist($critere);

            $entityManager->flush();
            $this->addFlash('success', "Poste enregistrée avec succès");
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/update.html.twig', [
            'type_autre_information'  => $typeAutreInformation,
            'poste' => $poste,
            'form' => $form,
            'autre_informations' => $informationComplementaires,
            'polices' => $polices,
        ]);
    }

    #[Route('/liste_poste', name: 'app_poste_liste', methods: ['GET', 'POST'])]
    public function listePoste(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/liste_poste.html.twig', [
            'postes' => $posteRepository->findBy(['deleted' => false]),
        ]);
    }
}
