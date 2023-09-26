<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function doSomething($value)
    {
        // ...
    }

    public function convertString($str){
        return intval($str);
    }

    public function extractWords($string, $separator = ' ') {
        $words = explode($separator, $string);
        $numberOfWords = count($words) / 2;
        $numberOfWords = (int)$numberOfWords;
        if ($numberOfWords >= count($words)) {
            return null;
        }

        $firstPart = implode($separator, array_slice($words, 0, $numberOfWords));

        $secondPart = implode($separator, array_slice($words, $numberOfWords));
        $word = nl2br($firstPart . "\n" . $secondPart);
        return  $word;
    }
}
