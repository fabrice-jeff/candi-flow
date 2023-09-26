<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Repository\AutreInformationCandidatureRepository;
use App\Repository\AutreInformationRepository;
use App\Repository\CandidatureRepository;
use App\Repository\FormationRepository;
use App\Repository\NiveauEtudeRepository;
use App\Repository\OutilInformatiqueCandidatureRepository;
use App\Repository\OutilsInformatiqueRepository;
use App\Repository\ParcoursGlobalRepository;
use App\Repository\ParcoursSpecifiqueRepository;
use App\Repository\StatutRepository;
use App\Repository\TotalExperienceRepository;
use App\Services\ExportExcelService;
use App\Utils\Constants\FixedValuesConstants;
use Denisok94\SymfonyExportXlsxBundle\Service\XlsxService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExportController extends AbstractController
{


    private AutreInformationRepository $autreInformationRepository;
    private CandidatureRepository $candidatureRepository;
    private EntityManagerInterface $manager;
    private OutilsInformatiqueRepository $outilsInformatiqueRepository;
    private NiveauEtudeRepository $niveauEtudeRepository;
    private FormationRepository $formationRepository;
    private TotalExperienceRepository $totalExperienceRepository;
    private OutilInformatiqueCandidatureRepository $outilInformatiqueCandidatureRepository;
    private ParcoursGlobalRepository $parcoursGlobalRepository;
    private ParcoursSpecifiqueRepository $parcoursSpecifiqueRepository;
    private AutreInformationCandidatureRepository $autreInformationCandidatureRepository;
    private StatutRepository $statutRepository;
    private XlsxService $export;

    public function __construct(AutreInformationRepository $autreInformationRepository, CandidatureRepository $candidatureRepository, EntityManagerInterface $manager, OutilsInformatiqueRepository $outilsInformatiqueRepository, NiveauEtudeRepository $niveauEtudeRepository, FormationRepository $formationRepository, TotalExperienceRepository $totalExperienceRepository, OutilInformatiqueCandidatureRepository $outilInformatiqueCandidatureRepository, ParcoursGlobalRepository $parcoursGlobalRepository, ParcoursSpecifiqueRepository $parcoursSpecifiqueRepository, AutreInformationCandidatureRepository $autreInformationCandidatureRepository, StatutRepository $statutRepository, XlsxService $export)
    {

        $this->autreInformationRepository = $autreInformationRepository;
        $this->candidatureRepository = $candidatureRepository;
        $this->manager = $manager;
        $this->outilsInformatiqueRepository = $outilsInformatiqueRepository;
        $this->niveauEtudeRepository = $niveauEtudeRepository;
        $this->formationRepository = $formationRepository;
        $this->totalExperienceRepository = $totalExperienceRepository;
        $this->outilInformatiqueCandidatureRepository = $outilInformatiqueCandidatureRepository;
        $this->parcoursGlobalRepository = $parcoursGlobalRepository;
        $this->parcoursSpecifiqueRepository = $parcoursSpecifiqueRepository;
        $this->autreInformationCandidatureRepository = $autreInformationCandidatureRepository;
        $this->statutRepository = $statutRepository;
        $this->export = $export;
    }


    #[Route('/export/{code}', name: 'app_export_excel',)]
    public function index(Poste $poste): Response
    {

        $critere = $poste->getCritere();
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
        $data = [];
        $colonne = ['A',' B','C', 'D', 'E','F', 'G', 'H','I','J', 'K', 'L', 'M', 'N','O', 'P', 'Q','R', 'S', 'T','U', 'V', 'W', 'X', 'Y', 'Z'];
        $finColonne = '';
        foreach ($candidaturesArray as $item) {
            $formationsArray = "";
            foreach ($item['formations'] as $formation) {
                $formationsArray .= "-" .$formation->getLibelle()."\n";
            }

            $outilsInformatiqueArray = "";
            foreach ($item['outils_candidatures'] as $autreOutils) {
                $outilsInformatiqueArray .= "-" .$autreOutils->getOutilInformatique()->getLibelle()."\n";
            }

            $totalExperienceArray = "";
            foreach ($item['total_experience'] as $totalExpe) {
                $totalExperienceArray .= "-  " .$totalExpe->getDuree().",".$totalExpe->getPoste().",". $totalExpe->getOrganisme()."\n";
            }

            $parcoursGlobalArray = "";
            foreach ($item['parcours_global'] as $parcoursG) {
                $parcoursGlobalArray .= "-  " .$parcoursG->getLibelle()."\n";
            }

            $parcoursSpecifiquesArray = "";
            foreach ($item['parcours_global'] as $parcoursSpe) {
                $parcoursSpecifiquesArray .= "-  " .$parcoursSpe->getLibelle()."\n";
            }

            $candidature = [];
            $candidature['N°'] = $item['candidature']->getId();
            if ($critere->isNomPrenoms()){
                $candidature['Nom & Prénoms']  = $item['candidature']->getNom(). " ".$item['candidature']->getPrenom();
            }
            if($critere->isNationalite()){
                $candidature['Nationalité']  = $item['candidature']->getNationalite();
            }
            if($critere->isSexe()){
                $candidature['Sexe'] = $item['candidature']->getSexe();
            }

            if($critere->isAgeExige()){
                $candidature['Age']  = $item['candidature']->getAge();
            }
            if($critere->isDiplome()){
                $candidature['Diplôme/Niveau/Domaine'] = $item['candidature']->getNiveauEtude()->getLibelle(). "/". $item['candidature']->getDomaine();
            }
            if($critere->isFormationPoste()){
                $candidature['Autre formation pertinentes en lien avec le poste']= $formationsArray;
            }
            if($critere->isLogicielSpecifique()){
                $candidature["Outils Informatiques\n(". $poste->getLogicielSpecifique().")"] = ($item['candidature']->isLogicielSpecifique()) ? 'Oui': 'Non';
            }
            if($critere->isAutreOutils()){
                $candidature['Autres outils informatiques'] = $outilsInformatiqueArray;
            }
            if($critere->isTotalExperiance()){
                $candidature["Total expérience sur CV \n (Durée, Poste, Organisme)"] = $totalExperienceArray;
            }
            if($critere->isParcoursGlobal()){
                $candidature["Parcours profesionnels global \n(". $poste->getDureeParcoursGlobal(). $poste->getPosteParcoursGlobal().")" ] = $parcoursGlobalArray;
            }
            if($critere->isParcoursSpecifique()){
                $candidature["Parcours profesionnels spécifique\n(".$poste->getDureeParcoursGlobal(). $poste->getPosteParcoursGlobal().")"] = $parcoursSpecifiquesArray;
            }
            if($critere->isAutreInformation()){
                $candidature = $this->autreInformation($candidature, $item['autre_information_candidatures']);
            }
            if($critere->isDecision()){
                $candidature['Décision'] = ($item['candidature']->isDecision())? "Acceptée" : "Rejétée";
            }
            if($critere->isDossierComplet()){
                $candidature['Dossier complet'] = ($item['candidature']->isDossierComplet())? "Oui" : "Non";
            }
            if($critere->isJustification()){
                $candidature['Justification de la Décision'] = $item['candidature']->getJustification();
            }
            if($critere->isContact()){
                $candidature["Contact\n(Téléphone et E-mail)"] = $item['candidature']->getContact(). "\n". $item['candidature']->getEmail();
            }

            $nombre = count($candidature);
            $finColonne = $colonne[$nombre];
            array_push($data,$candidature);
        }

        $fileName = 'my_first_excel.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $this->export->setFile($temp_file)->open();

        $this->export->getProperties()
            ->setCreator('Denis')
            ->setLastModifiedBy('Denis')
            ->setSubject('my_first_excel')
            ->setTitle('my_first_excel');


        // Définir l'alignement horizontal sur "center" pour toutes les lignes
        $this->export->getActiveSheet()
            ->getStyle('1:1048576') // Applique le style à toutes les lignes
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY);


        // Appliquer une couleur de fond à la première ligne (ligne d'en-tête)
        $this->export->getActiveSheet()
            ->getStyle('A1:'.$finColonne.'1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFA500'); //

        $this->export->getActiveSheet()
            ->getStyle('1:1048576')
            ->getAlignment()
            ->setWrapText(true);

        // Définir l'alignement vertical sur "top" pour toutes les lignes
        $this->export->getActiveSheet()
            ->getStyle('1:1048576')
            ->getAlignment()
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $key = 1;
        for($i =0 ; $i<count($colonne); $i++){
            if($colonne[$i] == $finColonne){
                $key += $i;
            }
        }
        for ($col = 50; $col <= 16384; $col++) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
            $this->export->getActiveSheet()->getColumnDimension($columnLetter)->setVisible(false);
        }
        foreach ($data as $line) {
            $this->export->write($line);
        }

        $this->export->close();
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }

    private function autreInformation(Array $candidature, Array $autreInforCand){
        foreach ($autreInforCand as $item) {
            $nomColonne = $item->getAutreInformation()->getNomColonne(). "\n(". $item->getAutreInformation()->getInformation(). ")";
            if($item->isChecked()){
                $candidature[$nomColonne] = 'Oui';
            }
            else {
                $candidature[$nomColonne] = 'Non';
            }
        }
        return $candidature;
    }

}
