<?php

namespace App\Livewire\Subdomain;

use App\Models\Domain;
use Livewire\Component;
use App\Models\Subdomain;
use Livewire\Attributes\Title;

class ManageSubdomain extends Component
{
    public $domainid;

    #[Title('Manage Subdomain')]

    public function getSubdomain(){

        //$subdomains= Subdomain::where('domainid',$this->domainid)->get();
        //return view('userdashboard.subdomain.manage_subdomain_lists',['subdomains'=> $subdomains]);
        // session()->flash('subdomains', $this->domainid);
         return redirect()->route('subdomain-lists',['domain'=>$this->domainid]);
        
    }
    public function render()
    {
        $domains= Domain::where('registrantid','yu7hdsy8394')->get();
        return view('livewire.subdomain.manage-subdomain',[
            'domains'=> $domains]);
    }
}
