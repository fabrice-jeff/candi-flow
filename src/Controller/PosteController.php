<?php

namespace App\Controller;

use App\Entity\Atout;
use App\Entity\AutreInformation;
use App\Entity\Connaissance;
use App\Entity\Critere;
use App\Entity\Domaine;
use App\Entity\DomaineConnaissance;
use App\Entity\NiveauEtude;
use App\Entity\ParcoursGlobal;
use App\Entity\ParcoursSpecifique;
use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\ConnaissanceRepository;
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
            'postes' => $posteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_poste_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, NiveauEtudeRepository $niveauEtudeRepository, ConnaissanceRepository $connaissanceRepository): Response
    {
        $poste = new Poste();
        $form = $this->createForm(PosteType::class, $poste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request);
            $critere = new Critere();
            ($request->get('nomPrenom')) ? $critere->setNomPrenoms(true) : $critere->setNomPrenoms(false);
            ($request->get('nationalite')) ? $critere->setNationalite(true) : $critere->setNationalite(false);
            ($request->get('date-naissance')) ? $critere->setDateNissance(true) : $critere->setDateNissance(false);
//            ($request->get('date-depot')) ? $critere->setDateDepotDossier(true) : $critere->setDateDepotDossier(false);
            ($request->get('contact')) ? $critere->setContact(true) : $critere->setContact(false);
//            ($request->get('email')) ? $critere->setEmail(true) : $critere->setEmail(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);
            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
                $poste->setDateFin((new \DateTime($request->get('dateFin'))));
            }
            else{
                $critere->setAgeExige(false);
            }
            if($request->get('diplome')){
                $critere->setDiplome(true);
                $poste->setNiveauEtude($niveauEtudeRepository->find($request->get('poste')['niveauEtude']));
                $poste->setDomaine($request->get('poste')['domaine']);
            }
            else{
                $critere->setDiplome(false);
            }
            if($request->get('formation_poste')){
//                dd($request->get('poste')['nombreFormation']);
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
                        ->setNomColonne($nom = $objet->nom)
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
            ($request->get('date-depot-dossier')) ? $critere->setDateDepotDossier(true) : $critere->setDateDepotDossier(false);
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

    #[Route('/liste_poste', name: 'app_poste_liste', methods: ['GET', 'POST'])]
    public function listePoste(PosteRepository $posteRepository): Response
    {
        return $this->render('poste/liste_poste.html.twig', [
            'postes' => $posteRepository->findAll(),
        ]);
    }
}
