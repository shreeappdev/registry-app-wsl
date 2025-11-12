<?php

namespace App\Livewire\Backend\Subdomain\Registration;

use Livewire\Component;
use App\Models\Domain;
use App\Helpers\Customdbresults;


class MultiSubdomainReg extends Component
{
    public $totalStep=11;
    public $currentStep=1;
    public $signingAuthority;
    public $selectedDomainid;
    public $selectedSigningAthority;
    public $selectedsSigningMethod;
    public $subdomainName;
    public $selectedMapping;
    public $mappingType;
    public $ips = [''];
    public $cName;
    public $keepSameMapping;
    public $isSameMapping= false;
    public $multiSubDomainName =[''];
 


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
    
    public function addEntry($entry)
    {
       
        if ($entry == 'ip' && count($this->ips) < 5) {   // max 5
           $this->ips[] = '';
        }elseif($entry == 'subdomain' && count($this->multiSubDomainName) < 10){
            $this->multiSubDomainName[] = '';
        }
    }

    public function removeEntry($entry,$index)
    {
        if($entry == 'ip'){
            unset($this->ips[$index]);
            $this->ips = array_values($this->ips);
        }elseif($entry == 'subdomain'){
            unset($this->multiSubDomainName[$index]);
            $this->multiSubDomainName = array_values($this->multiSubDomainName);
        }
        
    }

    public function validateData1()
    {

        $rules = [];
        $messages = [];

        if ($this->currentStep == 1) {
            $rules = [
                'selectedDomainid' => 'required',
                'selectedSigningAthority' => 'required',
                'selectedsSigningMethod' => 'required'
            ];
            $messages = [
                'selectedDomainid.required' => 'This field is required.',
                'selectedSigningAthority.required' => 'This field is required.',
                'selectedsSigningMethod.required' => 'This field is required.'
            ];
        }

        if ( !($this->isSameMapping) && $this->currentStep > 1 && $this->currentStep <= $this->totalStep ) {
            $rules = [
                'selectedMapping' => 'required',
                'cName' => [
                    'nullable',
                    'required_if:selectedMapping,cname',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
            ];

            if ($this->selectedMapping === 'ip') {
                $this->ips = array_map('trim', $this->ips);
                $rules['ips'] = ['required', 'array'];
                $rules['ips.*'] = ['required', 'ip', 'distinct'];
            }

            $this->multiSubDomainName = array_map('trim', $this->multiSubDomainName);
            $rules['multiSubDomainName'] = ['required', 'array'];
            $rules['multiSubDomainName.*'] = [
                'required',
                'distinct',
                'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
            ];
         
            $messages = array_merge($messages, [
                'selectedMapping.required' => 'This field is required.',
                'ips.*.required' => 'This field is required.',
                'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',
                'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',
                'multiSubDomainName.*.required' => 'This field is required.',
                'multiSubDomainName.*.regex' => 'Enter a valid subdomain (e.g., "abc" or "abc.xyz").',
                'multiSubDomainName.*.distinct' => 'Duplicate subdomain names are not allowed.',
            ]);
        }

        $this->validate($rules, $messages);
    }

    public function validateData()
    {
        
        if($this->currentStep == 1){
            $this->validate($this->rulesForStep1(), $this->messagesForStep1());
        }elseif($this->isSameMapping){
            $this->validate($this->rulesForSameMapping(), $this->messagesForSameMapping());                
        }else{

          

        }
    }

    private function rulesForSameMapping()
    {
        $rules = [
                'selectedMapping' => 'required',
                'cName' => [
                    'nullable',
                    'required_if:selectedMapping,cname',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
                'multiSubDomainName' => ['required', 'array'],
                'multiSubDomainName.*' => [
                    'required',
                    'distinct',
                    'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                ],
            ];

            if ($this->selectedMapping === 'ip') {
                $this->ips = array_map('trim', $this->ips);
                $rules['ips'] = ['required', 'array'];
                $rules['ips.*'] = ['required', 'ip', 'distinct'];
            }
            $this->multiSubDomainName = array_map('trim', $this->multiSubDomainName);  

        return $rules;      
    }

    private function messagesForSameMapping(){
        $messages =  [
                'selectedMapping.required' => 'This field is required.',
                'cName.required_if' => 'This field is required.',
                'cName.regex' => 'CNAME may only contain letters and spaces.',
                'ips.*.required' => 'This field is required.',
                'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',
                'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',
                'multiSubDomainName.*.required' => 'This field is required.',
                'multiSubDomainName.*.regex' => 'Enter a valid subdomain (e.g., "abc" or "abc.xyz").',
                'multiSubDomainName.*.distinct' => 'Duplicate subdomain names are not allowed.',
        ];

        return $messages;
    }

    private function rulesForStep1(){
        return [
                'selectedDomainid' => 'required',
                'selectedSigningAthority' => 'required',
                'selectedsSigningMethod' => 'required'
            ];
    }

    private function messagesForStep1(){
        return [
                'selectedDomainid.required' => 'This field is required.',
                'selectedSigningAthority.required' => 'This field is required.',
                'selectedsSigningMethod.required' => 'This field is required.'
            ];
    }

    public function updatedKeepSameMapping($value){
        $this->isSameMapping = $value;
    }

    public function updatedSelectedMapping($value){
        $this->mappingType = $value;
    }

    public function updatedSelectedDomainid($value){
        $this->signingAuthority = Customdbresults::domainDetails($value,['orgContactDetails', 'adminContactDetails']);           
    }

    public function register()
    {
      //  dd($this->multiSubDomainName);
        $this->resetErrorBag();
        $this->validateData();
    }

    public function getActiveDomainProperty(){
        return Domain::where('registrantid','yu7hdsy8394')
               ->where('activation_status','Active')
               ->where('lang','en')
               ->where('nic_hosting',1)
               ->get();
    }
    public function render()
    {
        return view('livewire.backend.subdomain.registration.multi-subdomain-reg');
    }
}
