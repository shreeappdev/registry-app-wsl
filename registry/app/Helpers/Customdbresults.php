<?php

namespace App\Helpers;

use App\Models\IdnLanguage;
use App\Models\Domain;
use App\Models\NodalOfficers;


class Customdbresults
{
    public static function getLanguges()
    {
        $getLanguage=IdnLanguage::all();
        return $getLanguage;
    }

    public static function getLangugeDetails($langid='en')
    {
        $getLangdetails=IdnLanguage::where('lang_code',$langid)->first();
        return $getLangdetails;
    }

    public static function domainDetails($domainid,$data=[]){
         if (empty($domainid)) return null; 

         $domain = Domain::with($data)
        ->where('domainid', $domainid)
        ->first();
        return $domain;
    }

    public static function nodalOfficersDetails($faid, $data=[]){
        if (empty($faid)) return null; 
         $domain = NodalOfficers::with($data)
        ->where('faid', $faid)
        ->first();
        return $domain;
    }


}