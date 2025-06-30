<?php

namespace App\Livewire\Subdomain;

use App\Models\Domain;
use App\Models\Contact;
use Livewire\Component;
use App\Models\Ministry;
use App\Models\Subdomain;
use App\Models\Department;
use App\Models\Organisation;
use Livewire\Attributes\Title;
use App\Models\Nameserver_data;
use App\Models\SubdomainLetter;

class Subdomaindetails extends Component
{
    public $subdomain;
    public $sl=1;
    #[Title('Subdomain Details')]
    public function render()
    {

        $subdomainDetails= Subdomain::where('subdomainid',$this->subdomain)->first();
        $subdomainLetters= $subdomainDetails->subdomainLetters; //Get on letters using one to many relation
        $domaindetails=Domain::where('domainid',$subdomainDetails->domainid)->first();
       //$subdomainLetters= SubdomainLetter::where('subdomainid',$this->subdomain)->get();

        $data=[
            'domaindetails'=>$domaindetails,
            'subdomaindetails'=>$subdomainDetails,
             'subdomainLetters'=>$subdomainLetters
                
           ];

       
        return view('livewire.subdomain.subdomaindetails',['data'=> $data]);
    }
}
