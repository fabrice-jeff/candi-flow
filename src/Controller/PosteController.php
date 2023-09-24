<?php

namespace App\Controller;

use App\Entity\AutreInformation;
use App\Entity\Critere;
use App\Entity\NiveauEtude;
use App\Entity\ParcoursGlobal;
use App\Entity\ParcoursSpecifique;
use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\AutreInformationRepository;
use App\Repository\NiveauEtudeRepository;
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
            'postes' => $posteRepository->findBy(['deleted' => false]),
        ]);
    }

    #[Route('/new', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NiveauEtudeRepository $niveauEtudeRepository,): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $critere = new Critere();
            $poste->setLibelle($request->get('poste')['libelle']);
            ($request->get('nomPrenom')) ? $critere->setNomPrenoms(true) : $critere->setNomPrenoms(false);
            ($request->get('nationalite')) ? $critere->setNationalite(true) : $critere->setNationalite(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);

            if($request->get('date-naissance')){
                $critere->setDateNissance(true);
                $poste->setDateFin((new \DateTime($request->get('dateFin'))));
            }else{
                $critere->setDateNissance(false);
            }

            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
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
                    $autreInformation = (new AutreInformation())
                        ->setNomColonne($objet->nom)
                        ->setInformation($objet->domaine)
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
            $poste->setCritere($critere);
            $entityManager->persist($poste);
            $entityManager->persist($critere);
            $entityManager->flush();
            $this->addFlash('success', "Poste enregistrée avec succès");
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/new.html.twig', [
            'poste' => $poste,
            'form' => $form,
        ]);
    }

    #[Route('/update/{code}', name: 'app_poste_update', methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $entityManager, NiveauEtudeRepository $niveauEtudeRepository,AutreInformationRepository $autreInformationRepository, Poste $poste): Response
    {
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        $informationComplementaires =  $autreInformationRepository->findBy(['deleted' => false, 'poste' =>$poste]);
        if ($form->isSubmitted() && $form->isValid()) {

            $poste->getCritere()->setDeleted(false);
            $poste->setDeleted(true);
            $critere = new Critere();
            $poste = new Poste();
            $poste->setLibelle($request->get('poste')['libelle']);
            ($request->get('nomPrenom')) ? $critere->setNomPrenoms(true) : $critere->setNomPrenoms(false);
            ($request->get('nationalite')) ? $critere->setNationalite(true) : $critere->setNationalite(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);

            if($request->get('date-naissance')){
                $critere->setDateNissance(true);
                $poste->setDateFin((new \DateTime($request->get('dateFin'))));
            }else{
                $critere->setDateNissance(false);
            }

            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
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
                    $autreInformation = (new AutreInformation())
                        ->setNomColonne($objet->nom)
                        ->setInformation($objet->domaine)
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
            $poste->setCritere($critere);
            $entityManager->persist($poste);
            $entityManager->persist($critere);
            $entityManager->flush();
            $this->addFlash('success', "Poste enregistrée avec succès");
            return $this->redirectToRoute('app_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('poste/update.html.twig', [
            'poste' => $poste,
            'form' => $form,
            'autre_informations' => $informationComplementaires,
        ]);
    }

    #[Route('/liste_poste', name: 'app_poste_liste', methods: ['GET', 'POST'])]
    public function listePoste(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/liste_poste.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }
}
