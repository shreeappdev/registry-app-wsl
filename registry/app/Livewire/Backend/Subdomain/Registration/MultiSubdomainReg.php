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
    //public $subdname;


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

    public function validateData()
    {     
        if($this->currentStep == 1){
            $rules = [
                'selectedDomainid' => 'required',
                'selectedSigningAthority' => 'required',
                'selectedsSigningMethod' => 'required'
            ];
            $messages = [
                'selectedDomainid.required' => 'this field is required',
                'selectedSigningAthority.required' => 'this field is required',
                'selectedsSigningMethod.required' => 'this field is required'
            ];
        }  
        
        if($this->currentStep > 1 && $this->currentStep <= $this->totalStep){
            $rules = [
                'selectedMapping' => 'required',
                // 'subdomainName' => [
                //     'required',
                //     'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                //     //  'unique:domain_fld_transactional,subdomainname'
                // ],
                'cName' => [
                    'nullable',
                    'required_if:selectedMapping,cname',
                    'regex:/^[a-zA-Z\s]+$/',
                ]
            ];
            if ($this->selectedMapping === 'ip') {
                $this->ips = array_map('trim', $this->ips);
                $rules['ips'] = ['required', 'array'];
                $rules['ips.*'] = ['required', 'ip', 'distinct'];
            }
             if ($this->isSameMapping) {
                $this->multiSubDomainName = array_map('trim', $this->multiSubDomainName);
                $rules['multiSubDomainName'] = ['required', 'array'];
                $rules['multiSubDomainName.*'] = ['required', 'ip', 'distinct'];
            }
            $messages = [
                'subdomainName.required' => 'this field is required',
                'subdomainName.unique' => 'This subdomain is already registered.',
                'selectedMapping.required' => 'this field is required',
                'ips.*.required' => 'this field is required',
                'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',          
                'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',  
                'multiSubDomainName.*.required' => 'this field is required',
            ];
        }

        // $rules = [
        //             'selectedDomainid' => 'required',
        //             'selectedSigningAthority' => 'required',
        //             'selectedsSigningMethod' => 'required',
                   // 'selectedMapping' => 'required',
                    // 'subdomainName' => [
                    //     'required',
                    //     'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                    //   //  'unique:domain_fld_transactional,subdomainname'
                    // ],
                    // 'cName' => [
                    //     'nullable',
                    //     'required_if:selectedMapping,cname',
                    //     'regex:/^[a-zA-Z\s]+$/',
                    // ],
               // ];

        // if ($this->selectedMapping === 'ip') {
        //     $this->ips = array_map('trim', $this->ips);
        //     $rules['ips'] = ['required', 'array'];
        //     $rules['ips.*'] = ['required', 'ip', 'distinct'];

        // }
        
        $messages =      [
                'selectedDomainid.required' => 'this field is required',
                'selectedSigningAthority.required' => 'this field is required',
                'selectedsSigningMethod.required' => 'this field is required',
                // 'subdomainName.required' => 'this field is required',
                // 'subdomainName.unique' => 'This subdomain is already registered.',
                // 'selectedMapping.required' => 'this field is required',
                // 'ips.*.required' => 'this field is required',
                // 'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',          
                // 'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',                                                
        ];

        $this->validate($rules,$messages );
     
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
