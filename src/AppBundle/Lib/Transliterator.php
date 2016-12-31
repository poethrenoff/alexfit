<?php
namespace AppBundle\Lib;

abstract class Transliterator
{
    public function transliterate(string $text)
    {
        $transliterator = new \Fresh\Transliteration\Transliterator();
        
        $result = $transliterator->ruToEn($text);
        
        $result = preg_replace('/\s+/', '-', $result);
        $result = preg_replace('/[^A-z-]/', '', $result);
        $result = strtolower($result);
        
        return $result; 
    }
}