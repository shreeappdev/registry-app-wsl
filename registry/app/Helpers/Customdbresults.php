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

    public static function domainDetails($d_id,$data=[]){
         $domain = Domain::with($data)
        ->where('domainid', $d_id)
        ->first();
        return $domain;
    }

    public static function nodalOfficersDetails($faid, $data=[]){
    //    dd($faid,$data);
         $domain = NodalOfficers::with($data)
        ->where('faid', $faid)
        ->first();
        return $domain;
    }


}