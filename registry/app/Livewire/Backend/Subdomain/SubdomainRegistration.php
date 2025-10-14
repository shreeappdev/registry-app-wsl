<?php

namespace App\Livewire\Subdomain;

use App\Models\Domain;
use Livewire\Component;
use Nette\Utils\Random;
use Livewire\Attributes\Title;
use App\Models\SubdomainLetter;

class SubdomainRegistration extends Component
{
    public $domainid;
    public $reg_type;
    public $currentStep;
    public $subdomainregletter;
    public $signing_process;
    public $contact_type;
    public $action;
    public $mapping;
    public $subdomainname;
    public $generatedSubdomainLetter;
    public $letterid;
    public $showModal = false;
    public $totalStep=2;
    
    #[Title('Subdomain Registration')]
    public function mount(){

        $this->currentStep = 1;
    }


    public function increaseStep(){
      
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;

        if($this->currentStep > $this->totalStep){
            $this->currentStep = $this->totalStep;
        }
     
    }

    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }

    public function validateData(){

        if( $this->currentStep == 1){
                $this->validate([
                    'domainid'=>'required',
                    'reg_type'=>'required',
                ],
               );
        }
    }

    public function render()
    {
        $domains=Domain::all();
        return view('livewire.subdomain.subdomain-registration',['domains'=>$domains]);
    }

    public function generateLetter()
    {

        $subdomainLetter= SubdomainLetter::updateOrCreate(
            ['domainid' => $this->domainid,'request_type' => 'registration'],
            ['filename' => "new",'subdomainname'=>$this->subdomainname,'subdomainid' => rand(2,10)]
        );

        $this->dispatch('formSubmitted',type:'success',title:'Letter Generated',text:$this->subdomainname,date:date('Y-m-d'),html:"<p>Letter is generated</p>");
    }
    public function register(){

       return view('livewire.subdomain.single-subdomain-registration');

    }


    public function getGeneratedLetters(){
        $this->generatedSubdomainLetter=SubdomainLetter::where('domainname',$this->domainid)->get();
    }

    public function openModal($letterid)
    {
        $this->letterid = $letterid;
        $subdomainname = SubdomainLetter::find($letterid);
        $this->showModal = true;
    }

    // Method to close the modal
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function uploadRegLetter(){

        
    }

    public function multipledomainRegister($id){
        
        return redirect()->route('multiplesubdomain_register',['id'=>$id]);
    }
}
