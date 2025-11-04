<?php

namespace App\Livewire\Backend\Subdomain\Registration;

use Illuminate\Support\Facades\Log;
use App\Helpers\Customdbresults;
use App\Models\Contact;
use Livewire\Component;
use App\Models\Domain;
use App\Models\SubdomainFldTransactional;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SingleSubdomainReg extends Component 
{
    public $selectedMapping;
    public $selectedDomainid;
    public $mappingType;
    public $ips = [''];
    public $selectedSigningAthority;
    public $selectedsSigningMethod;
    public $subdomainName;
    public $signingAuthority;
    public $cName;
   

    
    public function updatedSelectedDomainid($value){
        $this->signingAuthority = Customdbresults::domainDetails($this->selectedDomainid,['orgContactDetails', 'adminContactDetails']);           
    }

    public function updatedSelectedMapping($value){
        $this->mappingType = $value;
    }

     public function addIp()
    {
        if (count($this->ips) < 5) {   // max 5
           $this->ips[] = '';
        }
    }

    public function removeIp($index)
    {
        unset($this->ips[$index]);
        $this->ips = array_values($this->ips);
    }

    public function validateData()
    {               
        $rules = [
                    'selectedDomainid' => 'required',
                    'selectedSigningAthority' => 'required',
                    'selectedsSigningMethod' => 'required',
                    'selectedMapping' => 'required',
                    'subdomainName' => [
                        'required',
                        'regex:/^(?!-)(?!.*-$)(?!\.)[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)?$/',
                      //  'unique:domain_fld_transactional,subdomainname'
                    ],
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
        
        $messages =      [
                'selectedDomainid.required' => 'this field is required',
                'subdomainName.required' => 'this field is required',
                'subdomainName.unique' => 'This subdomain is already registered.',
                'selectedSigningAthority.required' => 'this field is required',
                'selectedsSigningMethod.required' => 'this field is required',
                'selectedMapping.required' => 'this field is required',
                'ips.*.required' => 'this field is required',
                'ips.*.ip' => 'Each IP must be a valid IPv4 or IPv6 address.',          
                'ips.*.distinct' => 'Duplicate IP addresses are not allowed.',                                                
        ];

        $this->validate($rules,$messages );
     
    }

    public function register()
    {
        //dd($this->selectedSigningAthority);
        $this->resetErrorBag();
        $this->validateData();
        try{
        
            $subdomainid = 'SUBD'.date('dmy').date('his');
            $domainname = Domain::where('domainid',$this->selectedDomainid)->value('domainname');
            $authorityDetails = Contact::selectedDetails($this->selectedSigningAthority);
            $subdomainname = $this->subdomainName.'.'.$domainname;

            // check,  Is subdomain already exist
            $exists = SubdomainFldTransactional::where('subdomainname', $subdomainname)->exists();
            if ($exists) {
                return $this->addError('subdomainName', 'This subdomain already exists.');
            }
        
            SubdomainFldTransactional::create([
                'subdomainid'=> $subdomainid,
                'subdomainname' => $subdomainname,
                'domainid' => $this->selectedDomainid,
                'multipleips' =>serialize($this->ips),
                'multiplecname' => serialize([$this->cName]), 
                'signedby' => $this->selectedSigningAthority          
            ]);

            // generate letter st 
            if( $this->selectedsSigningMethod == 'generateletter'){
                $data = [
                'domainname' => $domainname,
                'authorityName' => (!empty($authorityDetails) && $authorityDetails->c_name) ? $authorityDetails->c_name :'',
                'authorityDesg' => (!empty($authorityDetails) && $authorityDetails->designation) ? $authorityDetails->designation :'',
                'subdomainname' => $subdomainname,
                'ips' =>$this->ips,
                'cname' => $this->cName,
                'date' => date('m/d/Y')

                ];

                $pdf = Pdf::loadView('livewire.backend.Letterformat.subdomain_reg_letter',$data);
                $filename = letterName($subdomainname,$subdomainid,'sub_reg');           
                $path = storage_path("app/public/registrationletters/generated/{$filename}");           
                $pdf->save($path);
                $link = Storage::url("registrationletters/generated/{$filename}");
            
                $this->dispatch('subDomainReg', [
                    'type'  => 'success',
                    'title' => 'Letter Generated',
                    'text'  => $subdomainname,
                    'date'  => now()->format('Y-m-d'),
                    'html'  => "<p>Annexure I and II has been generated successfully.<br>
                                <a href='{$link}' target='_blank'>Download Letter.</a><br>
                                </p>",
                ]);    
            }
       // generate letter cl
        }catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
        }       
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
        return view('livewire.backend.subdomain.registration.single-subdomain-reg');
    }
}
