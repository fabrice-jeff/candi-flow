<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppServices
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    private $lengthRandomId;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->lengthRandomId = 6;
    }

    public function getServerAddress()
    {
        $serverAddress = $_ENV['siteLink'];;
        return $serverAddress;
    }

    public function getTableName($entity)
    {
        return $this->manager->getClassMetadata($entity)->getTableName();
    }

    public function getTablenamePrefix($entity)
    {
        return strtoupper(substr($this->manager->getClassMetadata($entity)->getTableName(), 0, 3));
    }

    public function checkIfEntityHasField($entity, $field)
    {
        $entityModel = $this->manager->getClassMetadata($entity);
        return $entityModel->hasField($field);
    }

    public function checkIfEntityHasAssociation($entity, $field)
    {
        $entityModel = $this->manager->getClassMetadata($entity);
        return $entityModel->hasAssociation($field);
    }

    function random_alphanumeric()
    {
        $length = $this->lengthRandomId;

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ12345689';
        $my_string = '';

        for ($i = 0; $i < $length; $i++) {
            $pos = mt_rand(0, strlen($chars) - 1);
            $my_string .= substr($chars, $pos, 1);
        }

        return $my_string;
    }

    function getMonthByNumber($number)
    {
        $months = [
            'Janvier' => 'Janvier',
            'Février' => 'Février',
            'Mars' => 'Mars',
            'Avril' => 'Avril',
            'Mai' => 'Mai',
            'Juin' => 'Juin',
            'Juillet'=> 'Juillet',
            'Août' => 'Août',
            'Septembre' => 'Septembre',
            'Octobre' => 'Octobre',
            'Novembre' => 'Novembre',
            'Décembre' => 'Décembre'
        ];

        return $months[$number];
    }


    function getNumberOfMonth($month)
    {
        $numbers = [
            'Janvier' => 1,
            'Février' => 2,
            'Mars' => 3,
            'Avril' => 4,
            'Mai' => 5,
            'Juin' => 6,
            'Juillet'=> 7,
            'Août' => 8,
            'Septembre' => 9,
            'Octobre' => 10,
            'Novembre' => 11,
            'Décembre' => 12
        ];

        return $numbers[$month];
    }

    public function generatePdf($html, $name, $position){
        if($position == 'p'){
            $orientation = 'portrait';
        }else{
            $orientation = 'landscape';
        }

        $pdf = new Dompdf(array('enable_remote' => true));

        $pdf->loadHtml($html);
        $pdf->setPaper('A4', $orientation);
        $pdf->render();
        
        $output = $pdf->output();

        $filePath = 'pdf/' . $name;

        file_put_contents($filePath, $output);

        return new BinaryFileResponse($filePath);
    }

    function rgbCssToHex($cssColor) {
        // Utilisez une expression régulière pour extraire les composantes R, G et B
        preg_match('/rgb\((\d+), (\d+), (\d+)\)/', $cssColor, $matches);

        if (count($matches) == 4) {
            $red = intval($matches[1]);
            $green = intval($matches[2]);
            $blue = intval($matches[3]);

            // Utilisez la fonction sprintf pour formater le code hexadécimal
            return sprintf("#%02x%02x%02x", $red, $green, $blue);
        } else {
            return false; // Le format CSS n'est pas correct
        }
    }


}