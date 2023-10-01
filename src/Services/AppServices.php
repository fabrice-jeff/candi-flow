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

    public function hsvToHex($hue, $saturation, $value) {
        $hue = $hue % 360;
        $saturation = max(0, min(100, $saturation));
        $value = max(0, min(100, $value));

        $chroma = ($value / 100) * ($saturation / 100);
        $h_prime = $hue / 60;
        $x = $chroma * (1 - abs($h_prime % 2 - 1));

        $r = $g = $b = 0;

        if ($h_prime >= 0 && $h_prime < 1) {
            $r = $chroma;
            $g = $x;
        } elseif ($h_prime >= 1 && $h_prime < 2) {
            $r = $x;
            $g = $chroma;
        } elseif ($h_prime >= 2 && $h_prime < 3) {
            $g = $chroma;
            $b = $x;
        } elseif ($h_prime >= 3 && $h_prime < 4) {
            $g = $x;
            $b = $chroma;
        } elseif ($h_prime >= 4 && $h_prime < 5) {
            $r = $x;
            $b = $chroma;
        } elseif ($h_prime >= 5 && $h_prime < 6) {
            $r = $chroma;
            $b = $x;
        }

        $m = ($value / 100) - $chroma;
        $r = ($r + $m) * 255;
        $g = ($g + $m) * 255;
        $b = ($b + $m) * 255;

        return sprintf("#%02x%02x%02x", round($r), round($g), round($b));
    }


    public function extractHSV($colorString) {
        preg_match('/hsv\((\d+), (\d+)%, (\d+)%\)/', $colorString, $matches);

        if (count($matches) == 4) {
            return array(
                'hue' => intval($matches[1]),
                'saturation' => intval($matches[2]),
                'value' => intval($matches[3])
            );
        } else {
            return false; // Le format HSV est incorrect
        }
    }

    public function hsvStringToHex($colorString) {
        $hsv = $this->extractHSV($colorString);

        if ($hsv !== false) {
            return $this->hsvToHex($hsv['hue'], $hsv['saturation'], $hsv['value']);
        } else {
            return false;
        }
    }


}