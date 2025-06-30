<?php

namespace App\Helpers;

use App\Models\IdnLanguage;

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

}