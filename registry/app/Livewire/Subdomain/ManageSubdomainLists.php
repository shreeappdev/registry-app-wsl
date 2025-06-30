<?php

namespace App\Livewire\Subdomain;


use Livewire\Component;
use App\Models\Subdomain;
use Livewire\Attributes\Title;

class ManageSubdomainLists extends Component
{ 
    
    public $domain;
    public $sl=1;
    protected $queryString = ['domain'];
    #[Title('Manage Subdomain List')]
    public function mount()
    {
        $this->domain;

    }
    public function render()
    {
  
        $subdomains= Subdomain::where('domainid',$this->domain)->get();
        return view('livewire.Subdomain.manage-subdomain-lists',['subdomains'=>$subdomains]);
    }
}
