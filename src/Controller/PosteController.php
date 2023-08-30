<?php

namespace App\Controller;

use App\Entity\Atout;
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
            ($request->get('contact')) ? $critere->setContact(true) : $critere->setContact(false);
            ($request->get('email')) ? $critere->setEmail(true) : $critere->setEmail(false);
            ($request->get('sexe')) ? $critere->setSexe(true) : $critere->setSexe(false);
            if($request->get('ageExige')){
                $critere->setAgeExige(true);
                $poste->setAge($request->get('poste')['age']);
                $poste->setDateFin($request->get('poste')['dateFin']);
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
            if($request->get('autre-formations')){
                $critere->setAutreFormation(true);
                $poste->setNombreFormation($request->get('poste')['nombreFormation']);
            }else{
                $critere->setAutreFormation(false);
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
                //Enregistrer les parcours profesionnels globals
                $parcoursGlobal = json_decode($request->get('poste_parcours_global'));
                foreach($parcoursGlobal as  $value){
                    $parcoursGlobal = (new ParcoursGlobal())->setDuree($value->duree)
                        ->setDomaine($value->domaine)
                        ->setPoste($poste);
                    $entityManager->persist($parcoursGlobal);
                }
            }
            else{
                $critere->setParcoursGlobal(false);
            }
            if($request->get('parcours-specifique')){
                $critere->setParcoursSpecifique(true);
                //Enregistrer les parcours profesionnels spécifiques
                $parcoursSpecifiques = json_decode($request->get('poste_parcours_specifique'));
                foreach($parcoursSpecifiques as  $value){
                    $parcoursSpecifique = (new ParcoursSpecifique())->setDuree($value->duree)
                        ->setDomaine($value->domaine)
                        ->setPoste($poste);
                    $entityManager->persist($parcoursSpecifique);
                }
            }
            else{
                $critere->setParcoursSpecifique(false);
            }
            if($request->get('connaissance')){
                $critere->setConnaissance(true);
                //Enregistrer les connaisances
                $connaissances = json_decode($request->get('poste_connaissance'));
                // dd($connaissances);

                $regrouped = array();

                foreach ($connaissances as $objet) {
                    $nom = $objet->nom;

                    if (!isset($regrouped[$nom])) {
                        $regrouped[$nom] = array();
                    }

                    $regrouped[$nom][] = $objet;
                }

                // dd($regrouped);
                foreach($regrouped as $key => $value){
                    $connaissance = (new Connaissance)
                        ->setPoste($poste)
                        ->setLibelle($key);
                    $entityManager->persist($connaissance);
                    foreach($value as $element){
                        $domaineConnaissance =  (new DomaineConnaissance())
                            ->setLibelle($element->domaine)
                            ->setConnaissance($connaissance);
                        $entityManager->persist($domaineConnaissance);
                    }
                }
            }
            else{
                $critere->setConnaissance(false);
            }
            if($request->get('atout')){
                $critere->setAtout(true);
                // Enregistrer des atouts
                $atouts = json_decode($request->get('poste_atout'));
                foreach($atouts as  $value){
                    $atout = (new Atout())->setNom($value)
                    ->setPoste($poste);
                    $entityManager->persist($atout);
                }
            }
            else{
                $critere->setAtout(false);
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


    #[Route('/add_etudiant/{code}', name: 'app_poste_candidat', methods: ['GET', 'POST'])]
    public function addEtudiant(Poste $poste, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => [
                    'class' => 'form-control default-date-flatpick'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'Femme' => "F",
                    'Homme' => "H"
                ],
                'placeholder' => "Sélectionner un sexe"

            ])
            ->add('domaine', EntityType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Domaine::class,
                'placeholder' => "Sélectionner un domaine"
            ])
            ->add('niveauEtude', EntityType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => NiveauEtude::class,
                'placeholder' => "Sélectionner un niveau d'étude"
            ])
            ->add('contact', TextType::class,  [
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
        ->getForm();
        $form->handleRequest($request);

        return $this->render('poste/add_candidat.html.twig', [
            'form' =>$form->createView()
        ]);
    }
    
}
