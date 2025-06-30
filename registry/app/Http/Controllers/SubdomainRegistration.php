<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;

class SubdomainRegistration extends Controller
{
    public static function getUserDomains(){

        $domains=Domain::where('registrantid','yu7hdsy8394')->where('activation_status','Active')->get();
    
        return view('userdashboard.subdomain.registration', compact('domains'));
    }
}
