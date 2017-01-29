<?php
namespace AppBundle\Lib;

abstract class Transliterator
{
    public function transliterate($text)
    {
        $transliterator = new \Fresh\Transliteration\Transliterator();
        
        $result = $transliterator->ruToEn($text);
        
        $result = preg_replace('/\s+/', '-', $result);
        $result = preg_replace('/[^A-z0-9._-]/', '', $result);
        $result = strtolower($result);
        
        return $result; 
    }
}