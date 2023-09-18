<?php

namespace App\Services;

class ExportExcelService
{
    public function filterData(&$str){
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strtr($str, '"')) $str = '"' . str_replace('"', '""', $str).'"';
    }

    public function exportExcelFile(array $data)
    {
        $fields = array('N ','Nom et prenoms', 'Nationalite');
        $excelData = implode("\t",array_values($fields)). "\n";
        foreach ($data as $line){
            $lineData = array('Bonjour','Bonsoir','Ok' );
            $excelData .= implode("\t",array_values($lineData)). "\n";

        }
        return  $excelData;
    }
}